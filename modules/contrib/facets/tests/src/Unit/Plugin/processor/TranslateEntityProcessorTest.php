<?php

namespace Drupal\Tests\facets\Unit\Plugin\processor;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\TypedData\EntityDataDefinition;
use Drupal\Core\Language\Language;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\TypedData\ComplexDataDefinitionInterface;
use Drupal\Core\TypedData\DataReferenceDefinitionInterface;
use Drupal\facets\Entity\Facet;
use Drupal\facets\Plugin\facets\facet_source\SearchApiDisplay;
use Drupal\facets\Plugin\facets\processor\TranslateEntityProcessor;
use Drupal\facets\Result\Result;
use Drupal\node\Entity\Node;
use Drupal\search_api\IndexInterface;
use Drupal\search_api\Item\FieldInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Unit test for processor.
 *
 * @group facets
 */
class TranslateEntityProcessorTest extends UnitTestCase {

  /**
   * The mocked facet.
   *
   * @var \Drupal\facets\FacetInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $facet;

  /**
   * The mocked language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $languageManager;

  /**
   * The mocked entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $entityTypeManager;

  /**
   * The original results for the facet, before transformation.
   *
   * @var \Drupal\facets\Result\ResultInterface[]
   */
  protected $original_results;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Mock the typed data chain.
    $target_field_definition = $this->getMock(EntityDataDefinition::class);
    $target_field_definition->expects($this->once())
      ->method('getEntityTypeId')
      ->willReturn('entity_type');
    $property_definition = $this->getMock(DataReferenceDefinitionInterface::class);
    $property_definition->expects($this->any())
      ->method('getTargetDefinition')
      ->willReturn($target_field_definition);
    $data_definition = $this->getMock(ComplexDataDefinitionInterface::class);
    $data_definition->expects($this->any())
      ->method('getPropertyDefinition')
      ->willReturn($property_definition);

    // Add the typed data definition to the search api field.
    $field = $this->getMock(FieldInterface::class);
    $field->expects($this->any())
      ->method('getDataDefinition')
      ->willReturn($data_definition);

    // Add the search api field to the index.
    $index = $this->getMock(IndexInterface::class);
    $index->expects($this->any())
      ->method('getField')
      ->willReturn($field);

    // Create a search api based facet source and link the index to it.
    $facet_source = $this->getMockBuilder(SearchApiDisplay::class)
      ->disableOriginalConstructor()
      ->getMock();
    $facet_source->expects($this->any())
      ->method('getIndex')
      ->willReturn($index);

    // Create the actual facet.
    $this->facet = $this->getMockBuilder(Facet::class)
      ->disableOriginalConstructor()
      ->getMock();

    // Return the configured facet source.
    $this->facet->expects($this->any())
      ->method('getFacetSource')
      ->willReturn($facet_source);
    // Add a field identifier.
    $this->facet->expects($this->any())
      ->method('getFieldIdentifier')
      ->willReturn('testfield');

    $this->original_results = [new Result(2, 2, 5)];
    $this->facet->setResults($this->original_results);

    // Mock language manager.
    $this->languageManager = $this->getMockBuilder(LanguageManagerInterface::class)
      ->disableOriginalConstructor()
      ->getMock();
    $language = new Language(['langcode' => 'en']);
    $this->languageManager->expects($this->any())
      ->method('getCurrentLanguage')
      ->will($this->returnValue($language));

    // Mock entity type manager.
    $this->entityTypeManager = $this->getMockBuilder(EntityTypeManagerInterface::class)
      ->disableOriginalConstructor()
      ->getMock();

    // Create and set a global container with the language manager and entity
    // type manager.
    $container = new ContainerBuilder();
    $container->set('language_manager', $this->languageManager);
    $container->set('entity_type.manager', $this->entityTypeManager);
    \Drupal::setContainer($container);
  }

  /**
   * Tests that node results were correctly changed.
   */
  public function testNodeResultsChanged() {
    // Mock a node and add the label to it.
    $node = $this->getMockBuilder(Node::class)
      ->disableOriginalConstructor()
      ->getMock();
    $node->expects($this->any())
      ->method('label')
      ->willReturn('shaken not stirred');
    $nodes = [
      2 => $node,
    ];
    $node_storage = $this->getMock(EntityStorageInterface::class);
    $node_storage->expects($this->any())
      ->method('loadMultiple')
      ->willReturn($nodes);
    $this->entityTypeManager->expects($this->exactly(1))
      ->method('getStorage')
      ->willReturn($node_storage);

    // Set expected results.
    $expected_results = [
      ['nid' => 2, 'title' => 'shaken not stirred'],
    ];

    // Without the processor we expect the id to display.
    foreach ($expected_results as $key => $expected) {
      $this->assertEquals($expected['nid'], $this->original_results[$key]->getRawValue());
      $this->assertEquals($expected['nid'], $this->original_results[$key]->getDisplayValue());
    }

    // With the processor we expect the title to display.
    /** @var \Drupal\facets\Result\ResultInterface[] $filtered_results */
    $processor = new TranslateEntityProcessor([], 'translate_entity', [], $this->languageManager, $this->entityTypeManager);
    $filtered_results = $processor->build($this->facet, $this->original_results);
    foreach ($expected_results as $key => $expected) {
      $this->assertEquals($expected['nid'], $filtered_results[$key]->getRawValue());
      $this->assertEquals($expected['title'], $filtered_results[$key]->getDisplayValue());
    }
  }

  /**
   * Tests that term results were correctly changed.
   */
  public function testTermResultsChanged() {
    // Mock term.
    $term = $this->getMockBuilder(Term::class)
      ->disableOriginalConstructor()
      ->getMock();
    $term->expects($this->once())
      ->method('label')
      ->willReturn('Burrowing owl');
    $terms = [
      2 => $term,
    ];
    $term_storage = $this->getMock(EntityStorageInterface::class);
    $term_storage->expects($this->any())
      ->method('loadMultiple')
      ->willReturn($terms);
    $this->entityTypeManager->expects($this->exactly(1))
      ->method('getStorage')
      ->willReturn($term_storage);

    // Set expected results.
    $expected_results = [
      ['tid' => 2, 'name' => 'Burrowing owl'],
    ];

    // Without the processor we expect the id to display.
    foreach ($expected_results as $key => $expected) {
      $this->assertEquals($expected['tid'], $this->original_results[$key]->getRawValue());
      $this->assertEquals($expected['tid'], $this->original_results[$key]->getDisplayValue());
    }

    /** @var \Drupal\facets\Result\ResultInterface[] $filtered_results */
    $processor = new TranslateEntityProcessor([], 'translate_entity', [], $this->languageManager, $this->entityTypeManager);
    $filtered_results = $processor->build($this->facet, $this->original_results);

    // With the processor we expect the title to display.
    foreach ($expected_results as $key => $expected) {
      $this->assertEquals($expected['tid'], $filtered_results[$key]->getRawValue());
      $this->assertEquals($expected['name'], $filtered_results[$key]->getDisplayValue());
    }
  }

  /**
   * Test that deleted entities still in index results doesn't display.
   */
  public function testDeletedEntityResults() {
    // Set original results.

    $term_storage = $this->getMock(EntityStorageInterface::class);
    $term_storage->expects($this->any())
      ->method('loadMultiple')
      ->willReturn([]);
    $this->entityTypeManager->expects($this->exactly(1))
      ->method('getStorage')
      ->willReturn($term_storage);

    // Processor should return nothing (and not throw an exception).
    /** @var \Drupal\facets\Result\ResultInterface[] $filtered_results */
    $processor = new TranslateEntityProcessor([], 'translate_entity', [], $this->languageManager, $this->entityTypeManager);
    $filtered_results = $processor->build($this->facet, $this->original_results);
    $this->assertEmpty($filtered_results);
  }

}
