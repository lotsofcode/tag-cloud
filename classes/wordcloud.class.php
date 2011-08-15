<?php

	/************************************************************\
	 *
	 *	wordCloud Copyright 2011 Derek Harvey
	 *	www.lotsofcode.com
	 *
	 *	This file is part of wordCloud.
	 *
	 *	wordCloud v2 is free software; you can redistribute it and/or modify
	 *	it under the terms of the GNU General Public License as published by
	 *	the Free Software Foundation; either version 2 of the License, or
	 *	(at your option) any later version.
	 *
	 *	wordCloud v2 is distributed in the hope that it will be useful,
	 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
	 *	GNU General Public License for more details.
	 *
	 *	You should have received a copy of the GNU General Public License
	 *	along with wordCloud; if not, write to the Free Software
	 *	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA	02111-1307	USA
	 *
	 \************************************************************/
	
	class wordCloud {
		var $version = '2.1';
		var $wordsArray = array();
		
		/*
		 * Custom format ourput of words
		 * 		 
		 * @transformation 
		 * upper and lower for change of case
		 * 
		 * @trim
		 * bool, applies trimming to word		 		 		 		 
		 */
		 
		var $formatting = array(
			'transformation' => 'lower',
			'trim' => true			
		);
		
		/*
		 * PHP 5 Constructor
		 *
		 * @param array $words
		 * 		 
		 * @return void
		 */
		
		function __construct($words = false) {
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
		 * PHP 4 Constructor
		 *
		 * @param array $words
		 * 		 
		 * @return void
		 */
		
		function wordCloud($words = false) {
			return $this->__construct($words);
		}
		
		/*
		 * Convert a string into a cloud
		 *
		 * @param string $string
		 * @return void
		 */
		
		function addString($string, $seperator = ' ') {
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
		
		function formatWord($string) {
			if($this->formatting['transformation']){
				switch($this->formatting['transformation']){
					case 'upper':
						$string = strtoupper($string);
						break;
					default:
		      			$string = strtolower($string);
				}
			}
			if($this->formatting['trim']){
				$string = trim($string);
			}
			return preg_replace('/[^a-z ]/', '', strip_tags($string));
		}
		
		/*
		 * Display user friendly message, for debugging mainly
		 *
		 * @param string $string
		 * @param array $value
		 *
		 * @return bool
		 */
		
		function notify($string, $value)
		{
			echo '<pre>';
			print_r($string);
			print_r($value);
			echo '</pre>';
			return false;
		}
		
		/*
		 * Assign word to array
		 *
		 * @param string $word
		 * 		 
		 * @return string
		 */
		
		function addWord($wordAttributes = array()) {
			if (is_string($wordAttributes)) {
				$wordAttributes = array('word' => $wordAttributes);
			}
			$wordAttributes['word'] = $this->formatWord($wordAttributes['word']);
			if (!array_key_exists('size', $wordAttributes)) {
				$wordAttributes = array_merge($wordAttributes, array('size' => 1));
			}
			if (!array_key_exists('word', $wordAttributes)) {
				return $this->notify('no word attribute', print_r($wordAttributes, true));
			}
			$word = $wordAttributes['word'];
			if (empty($this->wordsArray[$word])) {
				$this->wordsArray[$word] = array();
			}
			if (!empty($this->wordsArray[$word]['size']) && !empty($wordAttributes['size'])) {
				$wordAttributes['size'] = ($this->wordsArray[$word]['size'] + $wordAttributes['size']);
			} elseif (!empty($this->wordsArray[$word]['size'])) {
				$wordAttributes['size'] = $this->wordsArray[$word]['size'];
			}		
			$this->wordsArray[$word] = $wordAttributes;
			return $this->wordsArray[$word];
		}
		
		/*
		 * Assign multiple words to array
		 *
		 * @param string $word
		 * 		 
		 * @return string
		 */
		
		function addWords($words = array()) {
			if (!is_array($words)) {
				$words = func_get_args();
			}
			foreach ($words as $wordAttributes) {
				$this->addWord($wordAttributes);
			}					
		}
		
		/*
		 * Shuffle associated names in array
		 *
		 * @return array $this->wordsArray
		 */
		
		function shuffleCloud() {
			$keys = array_keys($this->wordsArray);
			shuffle($keys);
			if (count($keys) && is_array($keys)) {
				$tmpArray = $this->wordsArray;
				$this->wordsArray = array();
				foreach ($keys as $key => $value)
					$this->wordsArray[$value] = $tmpArray[$value];
			}
			return $this->wordsArray;
		}
		
		/*
		 * Get the class range using a percentage
		 *
		 * @returns int $class
		 */
		
		function getClassFromPercent($percent) {
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
		 * Sets a limit for the amount of clouds
		 *
		 * @param string $limit		 
		 *		 
		 * @returns string $this->limitAmount
		 */
		
		function setLimit($limit) {
			if (!empty($limit)) {
				$this->limitAmount = $limit;
			}
			return $this->limitAmount;
		}
		
		/*
		 * Gets the limited amount of clouds
		 *
		 * @returns string $wordCloud
		 */
		
		function limitCloud() {
			$i = 0;
			$wordsArray = array();
			foreach ($this->wordsArray as $key => $value) {
				if ($i < $this->limitAmount) {
					$wordsArray[$value['word']] = $value;
				}
				$i++;
			}
			$this->wordsArray = array();
			$this->wordsArray = $wordsArray;
			return $this->wordsArray;
		}
		
		/*
		 * Finds the maximum value of an array
		 *
		 * @param string $word		 
		 *		 
		 * @returns void
		 */
		
		function removeWord($word) {
			$this->removeWords[] = $this->formatWord($word);
		}
		
		/*
		 * Removes tags from the whole array
		 *
		 * @returns array $this->wordsArray
		 */
		
		function removeWords() {
			foreach ($this->wordsArray as $key => $value) {
				if (!in_array($value['word'], $this->removeWords)) {
					$wordsArray[$value['word']] = $value;
				}
			}
			$this->wordsArray = array();
			$this->wordsArray = $wordsArray;
			return $this->wordsArray;
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
		
		function orderBy($field, $direction = 'ASC') {
	        return $this->orderBy = array('field' => $field, 'direction' => $direction);
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
		
		function orderCloud($unsortedArray, $sortField, $sortWay = 'SORT_ASC') {
			$sortedArray = array();
			foreach ($unsortedArray as $uniqid => $row) {
				foreach ($row as $key => $value) {
					$sortedArray[$key][$uniqid] = strtolower($value);
				}
			}
			if ($sortWay) {
				array_multisort($sortedArray[$sortField], constant($sortWay), $unsortedArray);
			}
			return $unsortedArray;
		}
		
		/*
		 * Finds the maximum value of an array
		 *
		 * @returns string $max
		 */
		
		function getMax() {
			$max = 0;
			if (!empty($this->wordsArray)) {
				$p_size = 0;
				foreach ($this->wordsArray as $cKey => $cVal) {
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
		 * Create the HTML code for each word and apply font size.
		 *
		 * @returns string/array $return
		 */
		
		function showCloud($returnType = 'html') {
			if (!empty($this->removeWords)) {
				$this->removeWords();
			}
			if (empty($this->orderBy)) {
				$this->shuffleCloud();
			} else {
				$orderDirection = strtolower($this->orderBy['direction']) == 'desc' ? 'SORT_DESC' : 'SORT_ASC';
        		$this->wordsArray = $this->orderCloud($this->wordsArray, $this->orderBy['field'], $orderDirection);
			}
			if (!empty($this->limitAmount)) {
				$this->limitCloud();
			}
			$this->max = $this->getMax();
			if (is_array($this->wordsArray)) {
				$return = ($returnType == 'html' ? '' : ($returnType == 'array' ? array() : ''));
				foreach ($this->wordsArray as $word => $arrayInfo) {
					$sizeRange = $this->getClassFromPercent(($arrayInfo['size'] / $this->max) * 100);
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