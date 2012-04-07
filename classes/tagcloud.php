<?php

	/************************************************************\
	 *
	 *	tagcloud Copyright 2012 Derek Harvey
	 *	lotsofcode.com
	 *
	 *	This file is part of tagcloud.
	 *
	 *	tagcloud is free software; you can redistribute it and/or modify
	 *	it under the terms of the GNU General Public License as published by
	 *	the Free Software Foundation; either version 2 of the License, or
	 *	(at your option) any later version.
	 *
	 *	tagcloud is distributed in the hope that it will be useful,
	 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
	 *	GNU General Public License for more details.
	 *
	 *	You should have received a copy of the GNU General Public License
	 *	along with tagCloud; if not, write to the Free Software
	 *	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA	02111-1307	USA
	 *
	 \************************************************************/
	
	class tagcloud
	{
		/**
		 * Tag cloud version
		 */
		public $version = '3.0.0';
		
		/*
		 * Tag array container
		 */
		protected $_tagsArray = array();
		
		/**
 		 * List of tags to remove from final output
		 */
		protected $_removeTags = array();

		/**
 		 * Cached attributes for order comparison
		 */
		protected $_attributes = array();

		/*
		 * Amount to limit cloud by
		 */
		protected $_limit = null;

		/*
		 * Minimum length of string to filtered in string
		 */
		protected $_minLength = null;

		/*
		 * Custom format output of tags
		 * 		 
		 * transformation: upper and lower for change of case
		 * trim: bool, applies trimming to tag		 		 		 		 
		 */
		protected $_formatting = array(
			'transformation' => 'lower',
			'trim' => true			
		);
		
		/*
		 * Constructor
		 *
		 * @param array $tags
		 * 		 
		 * @return void
		 */
		public function __construct($tags = false)
		{
			if ($tags !== false) {
				if (is_string($tags)) {
					$this->addString($tags);
				} elseif (count($tags)) {
					foreach ($tags as $key => $value) {
						$this->addTag($value);
					}
				}
			}
		}
		
		/*
		 * Convert a string into a array
		 *
		 * @param string $string    The string to use
		 * @param string $seperator The seperator to extract the tags
		 *
		 * @return void
		 */
		public function addString($string, $seperator = ' ')
		{
			$inputArray = explode($seperator, $string);
			$tagArray = array();
			foreach ($inputArray as $inputTag) {
				$tagArray[]=$this->formatTag($inputTag);
			}
			$this->addTags($tagArray);
		}
		
		/*
		 * Parse tag into safe format 
		 *
		 * @param string $string
		 *
		 * @return string
		 */
		public function formatTag($string)
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
		 * Assign tag to array
		 *
		 * @param array $tagAttributes Tags or tag attributes array
		 * 		 
		 * @return array $this->tagsArray
		 */
		public function addTag($tagAttributes = array())
		{
			if (is_string($tagAttributes)) {
				$tagAttributes = array('tag' => $tagAttributes);
			}
			$tagAttributes['tag'] = $this->formatTag($tagAttributes['tag']);
			if (!array_key_exists('size', $tagAttributes)) {
				$tagAttributes = array_merge($tagAttributes, array('size' => 1));
			}
			if (!array_key_exists('tag', $tagAttributes)) {
				return false;
			}
			$tag = $tagAttributes['tag'];
			if (empty($this->_tagsArray[$tag])) {
				$this->_tagsArray[$tag] = array();
			}
			if (!empty($this->_tagsArray[$tag]['size']) && !empty($tagAttributes['size'])) {
				$tagAttributes['size'] = ($this->_tagsArray[$tag]['size'] + $tagAttributes['size']);
			} elseif (!empty($this->_tagsArray[$tag]['size'])) {
				$tagAttributes['size'] = $this->_tagsArray[$tag]['size'];
			}		
			$this->_tagsArray[$tag] = $tagAttributes;
			$this->addAttributes($tagAttributes);
			return $this->_tagsArray[$tag];
		}

		/*
		 * Add all attributes to cached array
		 *
		 * @return void
		 */
		public function addAttributes($attributes)
		{
			$this->_attributes = array_unique(
				array_merge(
					$this->_attributes,
					array_keys($attributes)
				)
			);
		}

		/*
		 * Get attributes from cache
		 *
		 * @return array $this->_attibutes
		 */
		public function getAttributes()
		{
			return $this->_attributes;
		}

		/*
		 * Assign multiple tags to array
		 *
		 * @param array $tags
		 * 		 
		 * @return void
		 */
		public function addTags($tags = array())
		{
			if (!is_array($tags)) {
				$tags = func_get_args();
			}
			foreach ($tags as $tagAttributes) {
				$this->addTag($tagAttributes);
			}					
		}
		
		/*
		 * Sets a minimum string length for the 
		 * tags to display
		 *
		 * @param int $minLength		 
		 *		 
		 * @returns obj $this
		 */
		public function setMinLength($minLength)
		{
			$this->_minLength = $minLength;
			return $this;
		}
		

		/*
		 * Gets the minimum length value
		 *		 
		 * @returns void
		 */
		public function getMinLength()
		{
			return $this->_minLength;
		}


		/*
		 * Sets a limit for the amount of clouds
		 *
		 * @param int $limit		 
		 *		 
		 * @returns obj $this
		 */
		public function setLimit($limit)
		{
			$this->_limit = $limit;
			return $this;
		}

		/*
		 * Get the limit for the amount tags 
		 * to display
		 *
		 * @param int $limit		 
		 *		 
		 * @returns int $this->_limit
		 */
		public function getLimit()
		{
			return $this->_limit;
		}

		/*
		 * Remove a tag from the array
		 *
		 * @param string $tag		 
		 *		 
		 * @returns obj $this
		 */
		public function setRemoveTag($tag)
		{
			$this->_removeTags[] = $this->formatTag($tag);
			return $this;
		}

		/*
		 * Remove multiple tags from the array
		 *
		 * @param array $tags		 
		 *		 
		 * @returns obj $this
		 */
		public function setRemoveTags($tags)
		{
			foreach ($tags as $tag) {
				$this->setRemoveTag($tag);
			}
			return $this;
		}

		/*
		 * Get the list of remove tags
		 *		 
		 * @returns array $this->_removeTags
		 */
		public function getRemoveTags()
		{
			return $this->_removeTags;
		}

		/*
		 * Assign the order field and order direction of the array
		 * 
		 * Order by tag or size / defaults to random		 		 
		 *
		 * @param array  $field
		 * @param string $sortway
		 *     		 
		 * @returns $this->orderBy
		 */
		public function setOrder($field, $direction = 'ASC')
		{
	        return $this->orderBy = array(
	        	'field' => $field,
	        	'direction' => $direction
			);
	    }
			
		/*
		 * Generate the output for each tag.
		 *
		 * @returns string/array $return
		 */
		public function render($returnType = 'html')
		{
			$this->_remove();
			$this->_minLength();
			if (empty($this->orderBy)) {
				$this->_shuffle();
			} else {
				$orderDirection = strtolower($this->orderBy['direction']) == 'desc' ? 'SORT_DESC' : 'SORT_ASC';
        		$this->_tagsArray = $this->_order(
        			$this->_tagsArray,
        			$this->orderBy['field'],
        			$orderDirection
        		);
			}
			$this->_limit();
			$max = $this->_getMax();
			if (is_array($this->_tagsArray)) {
				$return = ($returnType == 'html' ? '' : ($returnType == 'array' ? array() : ''));
				foreach ($this->_tagsArray as $tag => $arrayInfo) {
					$sizeRange = $this->_getClassFromPercent(($arrayInfo['size'] / $max) * 100);
					$arrayInfo['range'] = $sizeRange;
					if ($returnType == 'array') {
						$return [$tag] = $arrayInfo;
					} elseif ($returnType == 'html') {
						$return .= "<span class='tag size{$sizeRange}'> &nbsp; {$arrayInfo['tag']} &nbsp; </span>";
					}
				}
				return $return;
			}
			return false;
		}

		/*
		 * Removes tags from the whole array
		 * 
		 * @returns array $this->_tagsArray
		 */
		protected function _remove()
		{
			foreach ($this->_tagsArray as $key => $value) {
				if (!in_array($value['tag'], $this->getRemoveTags())) {
					$_tagsArray[$value['tag']] = $value;
				}
			}
			$this->_tagsArray = array();
			$this->_tagsArray = $_tagsArray;
			return $this->_tagsArray;
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
		 * Parses the array and retuns
		 * limited amount of items
		 *
		 * @returns array $this->_tagsArray
		 */
		protected function _limit()
		{
			$limit = $this->getLimit();
			if ($limit !== null) {
				$i = 0;
				$_tagsArray = array();
				foreach ($this->_tagsArray as $key => $value) {
					if ($i < $limit) {
						$_tagsArray[$value['tag']] = $value;
					}
					$i++;
				}
				$this->_tagsArray = array();
				$this->_tagsArray = $_tagsArray;
			}
			return $this->_tagsArray;
		}

		/*
		 * Reduces the array by removing strings
		 * with a length shorter than the minLength
		 *
		 * @returns array $this->_tagsArray
		 */
		protected function _minLength()
		{
			$limit = $this->getMinLength();
			if ($limit !== null) {
				$i = 0;
				$_tagsArray = array();
				foreach ($this->_tagsArray as $key => $value) {
					if (strlen($value['tag']) >= $limit) {
						$_tagsArray[$value['tag']] = $value;
					}
					$i++;
				}
				$this->_tagsArray = array();
				$this->_tagsArray = $_tagsArray;
			}
			return $this->_tagsArray;
		}

		/*
		 * Finds the maximum 'size' value of an array
		 *
		 * @returns string $max
		 */
		protected function _getMax()
		{
			$max = 0;
			if (!empty($this->_tagsArray)) {
				$p_size = 0;
				foreach ($this->_tagsArray as $cKey => $cVal) {
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
		 * @return array $this->_tagsArray The shuffled array
		 */
		protected function _shuffle()
		{
			$keys = array_keys($this->_tagsArray);
			shuffle($keys);
			if (count($keys) && is_array($keys)) {
				$tmpArray = $this->_tagsArray;
				$this->_tagsArray = array();
				foreach ($keys as $key => $value)
					$this->_tagsArray[$value] = $tmpArray[$value];
			}
			return $this->_tagsArray;
		}
		
		/*
		 * Get the class range using a percentage
		 *
		 * @returns int $class The respective class 
		 * name based on the percentage value
		 */
		protected function _getClassFromPercent($percent)
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
	}