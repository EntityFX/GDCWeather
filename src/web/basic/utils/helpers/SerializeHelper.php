<?php

namespace app\utils\helpers;

	/**
	 * 
	 * Содержит различные алгоритмы сеарилизации
	 * @author Артём
	 *
	 */
	class SerializeHelper
	{
		/**
		 * 
		 * Сериализует для передачи в хранимую процедуру
		 * @param array $array
		 */
		static public function SerializeForStoredProcedure($array)
		{
			if ($array!=null)
			{
                $str = '';
                foreach($array as $value)
				{
                    $str.=$value.';';
				}
			}
			return $str;
		}
		
		/**
		 * 
		 * Сериализует для IN выражения в SQL запросе
		 * @param array $array
		 */
		static public function serializeForINStatement($array)
		{
			$indexMax=count($array)-1;
			if ($indexMax>=0)
			{
				$str='(';
				foreach($array as $key => $value)
				{
					$str.=$value;
					if ($key<$indexMax) $str.=', ';
				}
				$str.=')';
			}
			return $str;
		} 
	}