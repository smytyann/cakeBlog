<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace Cake\Collection;

use AppendIterator;
use ArrayObject;
use Cake\Collection\Collection;
use Cake\Collection\Iterator\ExtractIterator;
use Cake\Collection\Iterator\FilterIterator;
use Cake\Collection\Iterator\InsertIterator;
use Cake\Collection\Iterator\MapReduce;
use Cake\Collection\Iterator\ReplaceIterator;
use Cake\Collection\Iterator\SortIterator;
use LimitIterator;

/**
 * Offers a handful of method to manipulate iterators
 */
trait CollectionTrait {

	use ExtractTrait;

/**
 * Executes the passed callable for each of the elements in this collection
 * and passes both the value and key for them on each step.
 * Returns the same collection for chaining.
 *
 * ###Example:
 *
 * {{{
 * $collection = (new Collection($items))->each(function($value, $key) {
 *	echo "Element $key: $value";
 * });
 * }}}
 *
 * @param callable $c callable function that will receive each of the elements
 * in this collection
 * @return \Cake\Collection\Collection
 */
	public function each(callable $c) {
		foreach ($this as $k => $v) {
			$c($v, $k);
		}
		return $this;
	}

/**
 * Looks through each value in the collection, and returns another collection with
 * all the values that pass a truth test. Only the values for which the callback
 * returns true will be present in the resulting collection.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration, the key of the element and this collection as
 * arguments, in that order.
 *
 * ##Example:
 *
 * Filtering odd numbers in an array, at the end only the value 2 will
 * be present in the resulting collection:
 *
 * {{{
 * $collection = (new Collection([1, 2, 3]))->filter(function($value, $key) {
 *	return $value % 2 === 0;
 * });
 * }}}
 *
 * @param callable $c the method that will receive each of the elements and
 * returns true whether or not they should be in the resulting collection.
 * @return \Cake\Collection\Iterator\FilterIterator
 */
	public function filter(callable $c) {
		return new FilterIterator($this, $c);
	}

/**
 * Looks through each value in the collection, and returns another collection with
 * all the values that do not pass a truth test. This is the opposite of `filter`.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration, the key of the element and this collection as
 * arguments, in that order.
 *
 * ##Example:
 *
 * Filtering even numbers in an array, at the end only values 1 and 3 will
 * be present in the resulting collection:
 *
 * {{{
 * $collection = (new Collection([1, 2, 3]))->reject(function($value, $key) {
 *	return $value % 2 === 0;
 * });
 * }}}
 *
 * @param callable $c the method that will receive each of the elements and
 * returns true whether or not they should be out of the resulting collection.
 * @return \Cake\Collection\Iterator\FilterIterator
 */
	public function reject(callable $c) {
		return new FilterIterator($this, function ($key, $value, $items) use ($c) {
			return !$c($key, $value, $items);
		});
	}

/**
 * Returns true if all values in this collection pass the truth test provided
 * in the callback.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration and  the key of the element as arguments, in that
 * order.
 *
 * ###Example:
 *
 * {{{
 * $overTwentyOne = (new Collection([24, 45, 60, 15]))->every(function($value, $key) {
 *	return $value > 21;
 * });
 * }}}
 *
 * @param callable $c a callback function
 * @return boolean true if for all elements in this collection the provided
 * callback returns true, false otherwise
 */
	public function every(callable $c) {
		foreach ($this as $key => $value) {
			if (!$c($value, $key)) {
				return false;
			}
		}
		return true;
	}

/**
 * Returns true if any of the values in this collection pass the truth test
 * provided in the callback.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration and the key of the element as arguments, in that
 * order.
 *
 * ###Example:
 *
 * {{{
 * $hasYoungPeople = (new Collection([24, 45, 15]))->every(function($value, $key) {
 *	return $value < 21;
 * });
 * }}}
 *
 * @param callable $c a callback function
 * @return boolean true if for all elements in this collection the provided
 * callback returns true, false otherwise
 */
	public function some(callable $c) {
		foreach ($this as $key => $value) {
			if ($c($value, $key) === true) {
				return true;
			}
		}
		return false;
	}

/**
 * Returns true if $value is present in this collection. Comparisons are made
 * both by value and type.
 *
 * @param mixed $value the value to check for
 * @return boolean true if $value is present in this collection
 */
	public function contains($value) {
		foreach ($this as $v) {
			if ($value === $v) {
				return true;
			}
		}
		return false;
	}

/**
 * Returns another collection after modifying each of the values in this one using
 * the provided callable.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration, the key of the element and this collection as
 * arguments, in that order.
 *
 * ##Example:
 *
 * Getting a collection of booleans where true indicates if a person is female:
 *
 * {{{
 * $collection = (new Collection($people))->map(function($person, $key) {
 *	return $person->gender === 'female';
 * });
 * }}}
 *
 * @param callable $c the method that will receive each of the elements and
 * returns the new value for the key that is being iterated
 * @return \Cake\Collection\Iterator\ReplaceIterator
 */
	public function map(callable $c) {
		return new ReplaceIterator($this, $c);
	}

/**
 * Folds the values in this collection to a single value, as the result of
 * applying the callback function to all elements. $zero is the initial state
 * of the reduction, and each successive step of it should be returned
 * by the callback function.
 *
 * @param callable $c The callback function to be called
 * @param mixed $zero The state of reduction
 * @return void
 */
	public function reduce(callable $c, $zero) {
		$result = $zero;
		foreach ($this as $k => $value) {
			$result = $c($result, $value, $k);
		}
		return $result;
	}

/**
 * Returns a new collection containing the column or property value found in each
 * of the elements, as requested in the $matcher param.
 *
 * The matcher can be a string with a property name to extract or a dot separated
 * path of properties that should be followed to get the last one in the path.
 *
 * If a column or property could not be found for a particular element in the
 * collection, that position is filled with null.
 *
 * ### Example:
 *
 * Extract the user name for all comments in the array:
 *
 * {{{
 * $items = [
 *	['comment' => ['body' => 'cool', 'user' => ['name' => 'Mark']],
 *	['comment' => ['body' => 'very cool', 'user' => ['name' => 'Renan']]
 * ];
 * $extracted = (new Collection($items))->extract('comment.user.name');
 *
 * //Result will look like this when converted to array
 * ['Mark', 'Renan']
 * }}}
 *
 * @param string $matcher a dot separated string symbolizing the path to follow
 * inside the hierarchy of each value so that the column can be extracted.
 * @return \Cake\Collection\Iterator\ExtractIterator
 */
	public function extract($matcher) {
		return new ExtractIterator($this, $matcher);
	}

/**
 * Returns the top element in this collection after being sorted by a property.
 * Check the sortBy method for information on the callback and $type parameters
 *
 * ###Examples:
 *
 * {{{
 * //For a collection of employees
 * $max = $collection->max('age');
 * $max = $collection->max('user.salary');
 * $max = $collection->max(function($e) {
 *	return $e->get('user')->get('salary');
 * });
 *
 * //Display employee name
 * echo $max->name;
 * }}}
 *
 * @param callable|string $callback the callback or column name to use for sorting
 * @param integer $type the type of comparison to perform, either SORT_STRING
 * SORT_NUMERIC or SORT_NATURAL
 * @see \Cake\Collection\Collection::sortBy()
 * @return mixed The value of the top element in the collection
 */
	public function max($callback, $type = SORT_NUMERIC) {
		$sorted = new SortIterator($this, $callback, SORT_DESC, $type);
		return $sorted->top();
	}

/**
 * Returns the bottom element in this collection after being sorted by a property.
 * Check the sortBy method for information on the callback and $type parameters
 *
 * ###Examples:
 *
 * {{{
 * //For a collection of employees
 * $min = $collection->min('age');
 * $min = $collection->min('user.salary');
 * $min = $collection->min(function($e) {
 *	return $e->get('user')->get('salary');
 * });
 *
 * //Display employee name
 * echo $min->name;
 * }}}
 *
 *
 * @param callable|string $callback the callback or column name to use for sorting
 * @param integer $type the type of comparison to perform, either SORT_STRING
 * SORT_NUMERIC or SORT_NATURAL
 * @see \Cake\Collection\Collection::sortBy()
 * @return mixed The value of the bottom element in the collection
 */
	public function min($callback, $type = SORT_NUMERIC) {
		$sorted = new SortIterator($this, $callback, SORT_ASC, $type);
		return $sorted->top();
	}

/**
 * Returns a sorted iterator out of the elements in this colletion,
 * ranked in ascending order by the results of running each value through a
 * callback. $callback can also be a string representing the column or property
 * name.
 *
 * The callback will receive as its first argument each of the elements in $items,
 * the value returned by the callback will be used as the value for sorting such
 * element. Please note that the callback function could be called more than once
 * per element.
 *
 * ###Example:
 *
 * {{{
 * $items = $collection->sortBy(function($user) {
 *	return $user->age;
 * });
 *
 * //alternatively
 * $items = $collection->sortBy('age');
 *
 * //or use a property path
 * $items = $collection->sortBy('department.name');
 *
 * // output all user name order by their age in descending order
 * foreach ($items as $user) {
 *	echo $user->name;
 * }
 * }}}
 *
 * @param callable|string $callback the callback or column name to use for sorting
 * @param integer $dir either SORT_DESC or SORT_ASC
 * @param integer $type the type of comparison to perform, either SORT_STRING
 * SORT_NUMERIC or SORT_NATURAL
 * @return \Cake\Collection\Collection
 */
	public function sortBy($callback, $dir = SORT_DESC, $type = SORT_NUMERIC) {
		return new Collection(new SortIterator($this, $callback, $dir, $type));
	}

/**
 * Splits a collection into sets, grouped by the result of running each value
 * through the callback. If $callback is is a string instead of a callable,
 * groups by the property named by $callback on each of the values.
 *
 * When $callback is a string it should be a property name to extract or
 * a dot separated path of properties that should be followed to get the last
 * one in the path.
 *
 * ###Example:
 *
 * {{{
 * $items = [
 *	['id' => 1, 'name' => 'foo', 'parent_id' => 10],
 *	['id' => 2, 'name' => 'bar', 'parent_id' => 11],
 *	['id' => 3, 'name' => 'baz', 'parent_id' => 10],
 * ];
 *
 * $group = (new Collection($items))->groupBy('parent_id');
 *
 * //Or
 * $group = (new Collection($items))->groupBy(function($e) {
 *	return $e['parent_id'];
 * });
 *
 * //Result will look like this when converted to array
 * [
 *	10 => [
 *		['id' => 1, 'name' => 'foo', 'parent_id' => 10],
 *		['id' => 3, 'name' => 'baz', 'parent_id' => 10],
 *	],
 *	11 => [
 *		['id' => 2, 'name' => 'bar', 'parent_id' => 11],
 *	]
 * ];
 * }}}
 *
 * @param callable|string $callback the callback or column name to use for grouping
 * or a function returning the grouping key out of the provided element
 * @return \Cake\Collection\Collection
 */
	public function groupBy($callback) {
		$callback = $this->_propertyExtractor($callback);
		$group = [];
		foreach ($this as $value) {
			$group[$callback($value)][] = $value;
		}
		return new Collection($group);
	}

/**
 * Given a list and a callback function that returns a key for each element
 * in the list (or a property name), returns an object with an index of each item.
 * Just like groupBy, but for when you know your keys are unique.
 *
 * When $callback is a string it should be a property name to extract or
 * a dot separated path of properties that should be followed to get the last
 * one in the path.
 *
 * ###Example:
 *
 * {{{
 * $items = [
 *	['id' => 1, 'name' => 'foo'],
 *	['id' => 2, 'name' => 'bar'],
 *	['id' => 3, 'name' => 'baz'],
 * ];
 *
 * $indexed = (new Collection($items))->indexBy('id');
 *
 * //Or
 * $indexed = (new Collection($items))->indexBy(function($e) {
 *	return $e['id'];
 * });
 *
 * //Result will look like this when converted to array
 * [
 *	1 => ['id' => 1, 'name' => 'foo'],
 *	3 => ['id' => 3, 'name' => 'baz'],
 *	2 => ['id' => 2, 'name' => 'bar'],
 * ];
 * }}}
 *
 * @param callable|string $callback the callback or column name to use for indexing
 * or a function returning the indexing key out of the provided element
 * @return \Cake\Collection\Collection
 */
	public function indexBy($callback) {
		$callback = $this->_propertyExtractor($callback);
		$group = [];
		foreach ($this as $value) {
			$group[$callback($value)] = $value;
		}
		return new Collection($group);
	}

/**
 * Sorts a list into groups and returns a count for the number of elements
 * in each group. Similar to groupBy, but instead of returning a list of values,
 * returns a count for the number of values in that group.
 *
 * When $callback is a string it should be a property name to extract or
 * a dot separated path of properties that should be followed to get the last
 * one in the path.
 *
 * ###Example:
 *
 * {{{
 * $items = [
 *	['id' => 1, 'name' => 'foo', 'parent_id' => 10],
 *	['id' => 2, 'name' => 'bar', 'parent_id' => 11],
 *	['id' => 3, 'name' => 'baz', 'parent_id' => 10],
 * ];
 *
 * $group = (new Collection($items))->countBy('parent_id');
 *
 * //Or
 * $group = (new Collection($items))->countBy(function($e) {
 *	return $e['parent_id'];
 * });
 *
 * //Result will look like this when converted to array
 * [
 *	10 => 2,
 *	11 => 1
 * ];
 * }}}
 *
 * @param callable|string $callback the callback or column name to use for indexing
 * or a function returning the indexing key out of the provided element
 * @return \Cake\Collection\Collection
 */
	public function countBy($callback) {
		$callback = $this->_propertyExtractor($callback);

		$mapper = function($value, $key, $mr) use ($callback) {
			$mr->emitIntermediate($value, $callback($value));
		};

		$reducer = function ($values, $key, $mr) {
			$mr->emit(count($values), $key);
		};
		return new Collection(new MapReduce($this, $mapper, $reducer));
	}

/**
 * Returns a new collection with the elements placed in a random order,
 * this function does not preserve the original keys in the collection.
 *
 * @return \Cake\Collection\Collection
 */
	public function shuffle() {
		$elements = iterator_to_array($this);
		shuffle($elements);
		return new Collection($elements);
	}

/**
 * Returns a new collection with maximum $size random elements
 * from this collection
 *
 * @param integer $size the maximum number of elements to randomly
 * take from this collection
 * @return \Cake\Collection\Collection
 */
	public function sample($size = 10) {
		return new Collection(new LimitIterator($this->shuffle(), 0, $size));
	}

/**
 * Returns a new collection with maximum $size elements in the internal
 * order this collection was created. If a second parameter is passed, it
 * will determine from what position to start taking elements.
 *
 * @param integer $size the maximum number of elements to take from
 * this collection
 * @param integer $from A positional offset from where to take the elements
 * @return \Cake\Collection\Collection
 */
	public function take($size = 1, $from = 0) {
		return new Collection(new LimitIterator($this, $from, $size));
	}

/**
 * Looks through each value in the list, returning a Collection of all the
 * values that contain all of the key-value pairs listed in $conditions.
 *
 * ###Example:
 *
 * {{{
 * $items = [
 *	['comment' => ['body' => 'cool', 'user' => ['name' => 'Mark']],
 *	['comment' => ['body' => 'very cool', 'user' => ['name' => 'Renan']]
 * ];
 *
 * $extracted = (new Collection($items))->match(['user.name' => 'Renan']);
 *
 * //Result will look like this when converted to array
 * [
 *	['comment' => ['body' => 'very cool', 'user' => ['name' => 'Renan']]
 * ]
 * }}}
 *
 * @param array $conditions a key-value list of conditions where
 * the key is a property path as accepted by `Collection::extract,
 * and the value the condition against with each element will be matched
 * @return \Cake\Collection\Collection
 */
	public function match(array $conditions) {
		$matchers = [];
		foreach ($conditions as $property => $value) {
			$extractor = $this->_propertyExtractor($property);
			$matchers[] = function($v) use ($extractor, $value) {
				return $extractor($v) == $value;
			};
		}

		$filter = function($value) use ($matchers) {
			$valid = true;
			foreach ($matchers as $match) {
				$valid = $valid && $match($value);
			}
			return $valid;
		};
		return $this->filter($filter);
	}

/**
 * Returns the first result matching all of the key-value pairs listed in
 * conditions.
 *
 * @param array $conditions a key-value list of conditions where the key is
 * a property path as accepted by `Collection::extract`, and the value the
 * condition against with each element will be matched
 * @see \Cake\Collection\Collection::match()
 * @return mixed
 */
	public function firstMatch(array $conditions) {
		return $this->match($conditions)->first();
	}

/**
 * Returns the first result in this collection
 *
 * @return mixed The first value in the collection will be returned.
 */
	public function first() {
		foreach ($this->take(1) as $result) {
			return $result;
		}
	}

/**
 * Returns a new collection as the result of concatenating the list of elements
 * in this collection with the passed list of elements
 *
 * @param array|\Traversable $items
 * @return \Cake\Collection\Collection
 */
	public function append($items) {
		$list = new AppendIterator;
		$list->append($this);
		$list->append(new Collection($items));
		return new Collection($list);
	}

/**
 * Returns a new collection where the values extracted based on a value path
 * and then indexed by a key path. Optionally this method can produce parent
 * groups based on a group property path.
 *
 * ### Examples:
 *
 * {{{
 * $items = [
 *	['id' => 1, 'name' => 'foo', 'parent' => 'a'],
 *	['id' => 2, 'name' => 'bar', 'parent' => 'b'],
 *	['id' => 3, 'name' => 'baz', 'parent' => 'a'],
 * ];
 *
 * $combined = (new Collection($items))->combine('id', 'name');
 *
 * //Result will look like this when converted to array
 * [
 *	1 => 'foo',
 *	2 => 'bar',
 *	3 => 'baz,
 * ];
 *
 * $combined = (new Collection($items))->combine('id', 'name', 'parent');
 *
 * //Result will look like this when converted to array
 * [
 *	'a' => [1 => 'foo', 3 => 'baz'],
 *	'b' => [2 => 'bar']
 * ];
 * }}}
 *
 * @param callable|string $keyPath the column name path to use for indexing
 * or a function returning the indexing key out of the provided element
 * @param callable|string $valuePath the column name path to use as the array value
 * or a function returning the value out of the provided element
 * @param callable|string $groupPath the column name path to use as the parent
 * grouping key or a function returning the key out of the provided element
 * @return \Cake\Collection\Collection
 */
	public function combine($keyPath, $valuePath, $groupPath = null) {
		$options = [
			'keyPath' => $this->_propertyExtractor($keyPath),
			'valuePath' => $this->_propertyExtractor($valuePath),
			'groupPath' => $groupPath ? $this->_propertyExtractor($groupPath) : null
		];

		$mapper = function($value, $key, $mapReduce) use ($options) {
			$rowKey = $options['keyPath'];
			$rowVal = $options['valuePath'];

			if (!($options['groupPath'])) {
				$mapReduce->emit($rowVal($value, $key), $rowKey($value, $key));
				return;
			}

			$key = $options['groupPath']($value, $key);
			$mapReduce->emitIntermediate(
				[$rowKey($value, $key) => $rowVal($value, $key)],
				$key
			);
		};

		$reducer = function($values, $key, $mapReduce) {
			$result = [];
			foreach ($values as $value) {
				$result += $value;
			}
			$mapReduce->emit($result, $key);
		};

		return new Collection(new MapReduce($this, $mapper, $reducer));
	}

/**
 * Returns a new collection where the values are nested in a tree-like structure
 * based on an id property path and a parent id property path.
 *
 * @param callable|string $idPath the column name path to use for determining
 * whether an element is parent of another
 * @param callable|string $parentPath the column name path to use for determining
 * whether an element is child of another
 * @return \Cake\Collection\Collection
 */
	public function nest($idPath, $parentPath) {
		$parents = [];
		$idPath = $this->_propertyExtractor($idPath);
		$parentPath = $this->_propertyExtractor($parentPath);
		$isObject = !is_array((new Collection($this))->first());

		$mapper = function($row, $key, $mapReduce) use (&$parents, $idPath, $parentPath) {
			$row['children'] = [];
			$id = $idPath($row, $key);
			$parentId = $parentPath($row, $key);
			$parents[$id] =& $row;
			$mapReduce->emitIntermediate($id, $parentId);
		};

		$reducer = function($values, $key, $mapReduce) use (&$parents, $isObject) {
			if (empty($key) || !isset($parents[$key])) {
				foreach ($values as $id) {
					$parents[$id] = $isObject ? $parents[$id] : new ArrayObject($parents[$id]);
					$mapReduce->emit($parents[$id]);
				}
				return;
			}

			foreach ($values as $id) {
				$parents[$key]['children'][] =& $parents[$id];
			}
		};

		$collection = new MapReduce($this, $mapper, $reducer);
		if (!$isObject) {
			$collection = (new Collection($collection))->map(function($value) {
				return (array)$value;
			});
		}

		return new Collection($collection);
	}

/**
 * Returns a new collection containing each of the elements found in `$values` as
 * a property inside the corresponding elements in this collection. The property
 * where the values will be inserted is described by the `$path` parameter.
 *
 * The $path can be a string with a property name or a dot separated path of
 * properties that should be followed to get the last one in the path.
 *
 * If a column or property could not be found for a particular element in the
 * collection as part of the path, the element will be kept unchanged.
 *
 * ### Example:
 *
 * Insert ages into a collection containing users:
 *
 * {{{
 * $items = [
 *	['comment' => ['body' => 'cool', 'user' => ['name' => 'Mark']],
 *	['comment' => ['body' => 'awesome', 'user' => ['name' => 'Renan']]
 * ];
 * $ages = [25, 28];
 * $inserted = (new Collection($items))->insert('comment.user.age', $ages);
 *
 * //Result will look like this when converted to array
 * [
 *	['comment' => ['body' => 'cool', 'user' => ['name' => 'Mark', 'age' => 25]],
 *	['comment' => ['body' => 'awesome', 'user' => ['name' => 'Renan', 'age' => 28]]
 * ];
 * }}}
 *
 * @param string $path a dot separated string symbolizing the path to follow
 * inside the hierarchy of each value so that the value can be inserted
 * @param array|\Traversable The values to be inserted at the specified path,
 * values are matched with the elements in this collection by its positional index.
 * @return \Cake\Collection\Iterator\InsertIterator
 */
	public function insert($path, $values) {
		return new InsertIterator($this, $path, $values);
	}

/**
 * Returns an array representation of the results
 *
 * @param boolean $preserveKeys whether to use the keys returned by this
 * collection as the array keys. Keep in mind that it is valid for iterators
 * to return the same key for different elements, setting this value to false
 * can help getting all items if keys are not important in the result.
 * @return array
 */
	public function toArray($preserveKeys = true) {
		return iterator_to_array($this, $preserveKeys);
	}

/**
 * Convert a result set into JSON.
 *
 * Part of JsonSerializable interface.
 *
 * @return array The data to convert to JSON
 */
	public function jsonSerialize() {
		return $this->toArray();
	}

/**
 * Iterates once all elements in this collection and executes all stacked
 * operations of them, finally it returns a new collection with the result.
 * This is useful for converting non-rewindable internal iterators into
 * a collection that can be rewound and used multiple times.
 *
 * A common use case is to re-use the same variable for calculating different
 * data. In those cases it may be helpful and more performant to first compile
 * a collection and then apply more operations to it.
 *
 * ### Example:
 *
 * {{{
 * $collection->map($mapper)->sortBy('age')->extract('name');
 * $compiled = $collection->compile();
 * $isJohnHere = $compiled->some($johnMatcher);
 * $allButJohn = $compiled->filter($johnMatcher);
 * }}}
 *
 * In the above example, had the collection not been compiled before, the
 * iterations for `map`, `sortBy` and `extract` would've been executed twice:
 * once for getting `$isJohnHere` and once for `$allButJohn`
 *
 * You can think of this method as a way to create save points for complex
 * calculations in a collection.
 *
 * @param boolean $preserveKeys whether to use the keys returned by this
 * collection as the array keys. Keep in mind that it is valid for iterators
 * to return the same key for different elements, setting this value to false
 * can help getting all items if keys are not important in the result.
 * @return \Cake\Collection\Collection
 */
	public function compile($preserveKeys = true) {
		return new Collection($this->toArray($preserveKeys));
	}

}
