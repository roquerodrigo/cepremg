<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis_daily",options={"engine":"MyISAM"})
 **/
class DavisDaily extends Davis
{
	/**
     * @var int Número de dados estatísticos na coluna
     * @Column(name="numberOfData", type="integer", nullable=false, options={"default":0})
     */
	private $numberOfData;
	
	/**
	 *	@return int 
	 */
	public function getNumberOfData() {
		return $numberOfData;
	}

	/**
	 * @param int 
	 *
	 * @return DavisMonthly
	 */
	public function setNumberOfData(int $numberOfData) {
		$this->numberOfData = $numberOfData;
		return $this;
	}
}