<?php
	class CwHelper extends Helper
	{
		private $cycleCount = 0;
	    var $helpers = array('Html','Number','Form');

		/**
		 * Hulpfunctie voor het rouleren van een class over bijv.
         * rijen in een tabel of divs.
         *
         * @param array $options    Array met opties
         * @param boolean $classTag Moet er een classtag gegenereerd worden?
         * @return string           Classname of classtag
		 */
		public function cycle($options = array('odd', 'even'), $classTag = false)
		{
			$optionsCount = count($options) - 1;

			if($classTag)
			{
				$return = 'class="'. $options[$this->cycleCount]. '"';
			}
			else
			{
				$return = $options[$this->cycleCount];
			}

			if($this->cycleCount < $optionsCount)
			{
				$this->cycleCount++;
			}
			else
			{
				$this->cycleCount = 0;
			}

			return $return;
		}

		public function datum($datum, $format = "%e %B %Y")
		{
			$timestamp = strtotime($datum);
			return strftime($format, $timestamp);
		}
	}
?>