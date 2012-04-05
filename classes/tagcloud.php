<?php

	/************************************************************\
	 *
	 *	tagcloud Copyright 2012 Derek Harvey
	 *	lotsofcode.com
	 *
	 *	This file is part of wordCloud.
	 *
	 *	tag cloud is free software; you can redistribute it and/or modify
	 *	it under the terms of the GNU General Public License as published by
	 *	the Free Software Foundation; either version 2 of the License, or
	 *	(at your option) any later version.
	 *
	 *	tag cloud is distributed in the hope that it will be useful,
	 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
	 *	GNU General Public License for more details.
	 *
	 *	You should have received a copy of the GNU General Public License
	 *	along with wordCloud; if not, write to the Free Software
	 *	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA	02111-1307	USA
	 *
	 \************************************************************/
	
	class tagcloud
	{
		/**
		 * Tag cloud version
		 */
		public $version = '2.1';
		
		/*
		 * Word array container
		 */
		protected $_wordsArray = array();
		
		/**
 		 * List of words to remove from final output
		 */
		protected $_removeWords = array();

		/**
 		 * Cached attributes
		 */
		protected $_attributes = array();

		/*
		 * Custom format ourput of words
		 * 		 
		 * transformation: upper and lower for change of case
		 * trim: bool, applies trimming to word		 		 		 		 
		 */
		protected $_formatting = array(
			'transformation' => 'lower',
			'trim' => true			
		);
		
		/*
		 * Constructor
		 *
		 * @param array $words
		 * 		 
		 * @return void
		 */
		public function __construct($words = false)
		{
			// If we are trying to parse some works, in any format / type
			if ($words !== false) {
				// If we have a string
				if (is_string($words)) {
					$this->addString($words);
				} elseif (count($words)) {
					foreach ($words as $key => $value) {
						$this->addWord($value);
					}
				}
			}
			return;
		}
		
		/*
		 * Convert a string into a cloud
		 *
		 * @param string $string
		 * @return void
		 */
		public function addString($string, $seperator = ' ')
		{
			$inputArray = explode($seperator, $string);
			$wordArray = array();
			foreach ($inputArray as $inputWord) {
				$wordArray[]=$this->formatWord($inputWord);
			}
			$this->addWords($wordArray);
		}
		
		/*
		 * Parse word into safe format 
		 *
		 * @param string $string
		 *
		 * @return string
		 */
		public function formatWord($string)
		{
			if ($this->_formatting['transformation']) {
				switch ($this->_formatting['transformation']) {
					case 'upper':
						$string = strtoupper($string);
						break;
					default:
		      			$string = strtolower($string);
				}
			}
			if ($this->_formatting['trim']) {
				$string = trim($string);
			}
			return preg_replace('/[^\w ]/u', '', strip_tags($string));
		}

		
		/*
		 * Assign word to array
		 *
		 * @param array $word
		 * 		 
		 * @return array
		 */
		public function addWord($wordAttributes = array())
		{
			if (is_string($wordAttributes)) {
				$wordAttributes = array('word' => $wordAttributes);
			}
			$wordAttributes['word'] = $this->formatWord($wordAttributes['word']);
			if (!array_key_exists('size', $wordAttributes)) {
				$wordAttributes = array_merge($wordAttributes, array('size' => 1));
			}
			if (!array_key_exists('word', $wordAttributes)) {
				return false;
			}
			$word = $wordAttributes['word'];
			if (empty($this->_wordsArray[$word])) {
				$this->_wordsArray[$word] = array();
			}
			if (!empty($this->_wordsArray[$word]['size']) && !empty($wordAttributes['size'])) {
				$wordAttributes['size'] = ($this->_wordsArray[$word]['size'] + $wordAttributes['size']);
			} elseif (!empty($this->_wordsArray[$word]['size'])) {
				$wordAttributes['size'] = $this->_wordsArray[$word]['size'];
			}		
			$this->_wordsArray[$word] = $wordAttributes;
			$this->addAttributes($wordAttributes);
			return $this->_wordsArray[$word];
		}

		public function addAttributes($attributes)
		{
			$this->_attributes = array_unique(
				array_merge(
					$this->_attributes,
					array_keys($attributes)
				)
			);
		}
		public function getAttributes()
		{
			return $this->_attributes;
		}

		/*
		 * Assign multiple words to array
		 *
		 * @param array $word
		 * 		 
		 * @return void
		 */
		public function addWords($words = array())
		{
			if (!is_array($words)) {
				$words = func_get_args();
			}
			foreach ($words as $wordAttributes) {
				$this->addWord($wordAttributes);
			}					
		}
		
		/*
		 * Sets a limit for the amount of clouds
		 *
		 * @param string $limit		 
		 *		 
		 * @returns string $this->limitAmount
		 */
		public function setLimit($limit)
		{
			$this->limitAmount = $limit;
			return $this;
		}

		/*
		 * Sets a limit for the amount of clouds
		 *
		 * @param string $limit		 
		 *		 
		 * @returns string $this->limitAmount
		 */
		public function getLimit()
		{
			return $this->limitAmount;
		}

		/*
		 * Remove a word from the array
		 *
		 * @param string $word		 
		 *		 
		 * @returns voidgetAttributes
		 */
		public function setRemoveWord($word)
		{
			$this->_removeWords[] = $this->formatWord($word);
		}

		/*
		 * Remove multiple words from the array
		 *
		 * @param array $words		 
		 *		 
		 * @returns void
		 */
		public function setRemoveWords($words)
		{
			foreach ($words as $word) {
				$this->removeWord($word);
			}
		}

		/*
		 * Remove multiple words from the array
		 *
		 * @param array $words		 
		 *		 
		 * @returns void
		 */
		public function getRemoveWords()
		{
			return $this->_removeWords;
		}

		/*
		 * Assign the order field and order direction of the cloud
		 * 
		 * Order by word or size / defaults to random		 		 
		 *
		 * @param array $field
		 * @param string $sortway
		 *     		 
		 * @returns void
		 */
		public function setOrder($field, $direction = 'ASC')
		{
	        return $this->orderBy = array(
	        	'field' => $field,
	        	'direction' => $direction
			);
	    }
			
		/*
		 * Removes tags from the whole array
		 * 
		 * @returns array $this->_wordsArray
		 */
		protected function _remove()
		{
			foreach ($this->_wordsArray as $key => $value) {
				if (!in_array($value['word'], $this->getRemoveWords())) {
					$_wordsArray[$value['word']] = $value;
				}
			}
			$this->_wordsArray = array();
			$this->_wordsArray = $_wordsArray;
			return $this->_wordsArray;
		}

		/*
		 * Orders the cloud by a specific field
		 *
		 * @param array $unsortedArray
		 * @param string $sortField
		 * @param string $sortWay
		 *     		 
		 * @returns array $unsortedArray
		 */
		protected function _order($unsortedArray, $sortField, $sortWay = 'SORT_ASC')
		{
			$sortedArray = array();
			foreach ($unsortedArray as $uniqid => $row) {
				foreach ($this->getAttributes() as $attr) {
					if (isset($row[$attr])) {
						$sortedArray[$attr][$uniqid] = $unsortedArray[$uniqid][$attr];
					} else {
						$sortedArray[$attr][$uniqid] = null;
					}
				}
			}
			if ($sortWay) {
				array_multisort($sortedArray[$sortField], constant($sortWay), $unsortedArray);
			}
			return $unsortedArray;
		}
		
		/*
		 * Gets the limited amount of clouds
		 *
		 * @returns array $wordsArray
		 */
		protected function _limit()
		{
			$i = 0;
			$_wordsArray = array();
			foreach ($this->_wordsArray as $key => $value) {
				if ($i < $this->getLimit()) {
					$_wordsArray[$value['word']] = $value;
				}
				$i++;
			}
			$this->_wordsArray = array();
			$this->_wordsArray = $_wordsArray;
			return $this->_wordsArray;
		}
		
		/*
		 * Finds the maximum value of an array
		 *
		 * @returns string $max
		 */
		protected function _getMax()
		{
			$max = 0;
			if (!empty($this->_wordsArray)) {
				$p_size = 0;
				foreach ($this->_wordsArray as $cKey => $cVal) {
					$c_size = $cVal['size'];
					if ($c_size > $p_size) {
			            $max = $c_size;
						$p_size = $c_size;
			        }
				}
			}
			return $max;
		}	

		/*
		 * Shuffle associated names in array
		 *
		 * @return array $this->_wordsArray The shuffled array
		 */
		private function _shuffle()
		{
			$keys = array_keys($this->_wordsArray);
			shuffle($keys);
			if (count($keys) && is_array($keys)) {
				$tmpArray = $this->_wordsArray;
				$this->_wordsArray = array();
				foreach ($keys as $key => $value)
					$this->_wordsArray[$value] = $tmpArray[$value];
			}
			return $this->_wordsArray;
		}
		
		/*
		 * Get the class range using a percentage
		 *
		 * @returns int $class The respective class 
		 * name based on the percentage value
		 */
		private function _getClassFromPercent($percent)
		{
			$percent = floor($percent);
			if ($percent >= 99)
				$class = 9;
			elseif ($percent >= 70)
				$class = 8;
			elseif ($percent >= 60)
				$class = 7;
			elseif ($percent >= 50)
				$class = 6;
			elseif ($percent >= 40)
				$class = 5;
			elseif ($percent >= 30)
				$class = 4;
			elseif ($percent >= 20)
				$class = 3;
			elseif ($percent >= 10)
				$class = 2;     
			elseif ($percent >= 5)
				$class = 1;
			else
				$class = 0;
			return $class;
		}

		/*
		 * Create the HTML code for each word and apply font size.
		 *
		 * @returns string/array $return
		 */
		
		function showCloud($returnType = 'html') {


			//echo '<pre>'; print_r($this->getAttributes());

			$this->_remove();
			if (empty($this->orderBy)) {
				$this->_shuffle();
			} else {
				$orderDirection = strtolower($this->orderBy['direction']) == 'desc' ? 'SORT_DESC' : 'SORT_ASC';
        		$this->_wordsArray = $this->_order(
        			$this->_wordsArray,
        			$this->orderBy['field'],
        			$orderDirection
        		);
			}
			if (!empty($this->limitAmount)) {
				$this->_limit();
			}
			$max = $this->_getMax();
			if (is_array($this->_wordsArray)) {
				$return = ($returnType == 'html' ? '' : ($returnType == 'array' ? array() : ''));
				foreach ($this->_wordsArray as $word => $arrayInfo) {
					$sizeRange = $this->_getClassFromPercent(($arrayInfo['size'] / $max) * 100);
					$arrayInfo['range'] = $sizeRange;
					if ($returnType == 'array') {
						$return [$word] = $arrayInfo;
					} elseif ($returnType == 'html') {
						$return .= "<span class='word size{$sizeRange}'> &nbsp; {$arrayInfo['word']} &nbsp; </span>";
					}
				}
				return $return;
			}
			return false;
		}
	}