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
namespace Cake\Collection\Iterator;

use Cake\Collection\Collection;

/**
 * Creates an iterator from another iterator that will modify each of the values
 * by converting them using a callback function.
 */
class ReplaceIterator extends Collection {

/**
 * The callback function to be used to modify each of the values
 *
 * @var callable
 */
	protected $_callback;

/**
 * Creates an iterator from another iterator that will modify each of the values
 * by converting them using a callback function.
 *
 * Each time the callback is executed it will receive the value of the element
 * in the current iteration, the key of the element and the passed $items iterator
 * as arguments, in that order.
 *
 * @param array|\Traversable $items the items to be filtered
 * @param callable $callback
 */
	public function __construct($items, callable $callback) {
		$this->_callback = $callback;
		parent::__construct($items);
	}

/**
 * Returns the value returned by the callback after passing the current value in
 * the iteration
 *
 * @return mixed
 */
	public function current() {
		$callback = $this->_callback;
		return $callback(parent::current(), $this->key(), $this->getInnerIterator());
	}

}
