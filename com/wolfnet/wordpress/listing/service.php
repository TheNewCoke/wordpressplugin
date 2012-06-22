<?php

/**
 * This class is the listingService and is a Facade used to interact with all other listing information.
 * 
 * @package       com.wolfnet.wordpress
 * @subpackage    listing
 * @title         service.php
 * @extends       com_ajmichels_wppf_abstract_service
 * @implements    com_ajmichels_wppf_interface_iService
 * @singleton     True
 * @contributors  AJ Michels (aj.michels@wolfnet.com)
 * @version       1.0
 * @copyright     Copyright (c) 2012, WolfNet Technologies, LLC
 * 
 */
class com_wolfnet_wordpress_listing_service
extends com_ajmichels_wppf_abstract_service
implements com_ajmichels_wppf_interface_iService
{
	
	
	/* SINGLETON ENFORCEMENT ******************************************************************** */
	
	/**
	 * This private static property holds the singleton instance of this class.
	 *
	 * @type  com_wolfnet_wordpress_listing_service
	 * 
	 */
	private static $instance;
	
	
	/**
	 * This static method is used to retrieve the singleton instance of this class.
	 * 
	 * @return  com_wolfnet_wordpress_listing_service
	 * 
	 */
	public static function getInstance ()
	{
		if ( !isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	
	/* PROPERTIES ******************************************************************************* */
	
	/**
	 * This property holds a reference to the WPPF Data Service instance within the plugin instance.
	 * 
	 * @type  com_ajmichels_wppf_data_service
	 * 
	 */
	private $dataService;
	
	
	/**
	 * This property holds a reference to the Web Service URL object which represents the URI which 
	 * will be used to retrieve data from a remove service.
	 * 
	 * @type  com_ajmichels_wppf_data_webServiceUrl
	 * 
	 */
	private $webServiceUrl;
	
	
	/**
	 * This property holds a reference to the WPPF Option Manager instance within the plugin 
	 * instance.
	 * 
	 * @type  com_ajmichels_wppf_option_manager
	 * 
	 */
	private $optionManager;
	
	
	/* CONSTRUCTOR ****************************************************************************** */
	
	/**
	 * This constructor method is private becuase this class is a singleton and can only be retrieved
	 * by statically calling the getInstance method.
	 * 
	 * @return  void
	 * 
	 */
	private function __construct ()
	{
	}
	
	
	/* PUBLIC METHODS *************************************************************************** */
	
	/**
	 * This method returns all featured property listings.
	 * 
	 * @param   string   $owner_type  The type of data that should be returned 'agent_broker', 
	 *                                'agent', or 'broker'.
	 * @param   numeric  $maxResults  The maximum number of listings which can be returned from the 
	 *                                web service request. The cap is 50.
	 * @return  array    An array of listing objects (com_wolfnet_wordpress_listing_entity)
	 * 
	 */
	public function getFeaturedListings ( $owner_type, $maxResults )
	{
		$this->setFeaturedListingsData( $owner_type, $maxResults );
		return $this->getDAO()->findAll();
	}
	
	
	/**
	 * This method returns all grid property listings.
	 * 
	 * @param   numeric  $minPrice    The minimum price for listings which can be returned.
	 * @param   numeric  $maxPrice    The maximum price for listings which can be returned.
	 * @param   string   $city        The name of a city to limit listing results to.
	 * @param   string   $zipcode     The zipcode to limit listing results to.
	 * @param   string   $owner_type  The type of data that should be returned 'agent_broker', 
	 *                                'agent', or 'broker'.
	 * @param   numeric  $maxResults  The maximum number of listings which can be returned from the 
	 *                                web service request. The cap is 50.
	 * @return  array    An array of listing objects (com_wolfnet_wordpress_listing_entity)
	 * 
	 */
	public function getGridListings ( $minPrice, $maxPrice, $city, $zipcode, $owner_type, $maxResults )
	{
		$this->setGridListingData( $minPrice, $maxPrice, $city, $zipcode, $owner_type, $maxResults );
		return $this->getDAO()->findAll();
	}
	
	
	/**
	 * This method gets an array of prices. This data is used for drop down lists in the quick 
	 * search and admin forms.
	 * 
	 * @return  array  An array of associative arrays containing price data.  Each associative array 
	 *                 contains a 'value' key and a 'label' key.
	 * 
	 */
	public function getPriceData ()
	{
		return array(
			array( value => 250,       label => '$250' ),
			array( value => 500,       label => '$500' ),
			array( value => 700,       label => '$700' ),
			array( value => 800,       label => '$800' ),
			array( value => 900,       label => '$900' ),
			array( value => 1000,      label => '$1,000' ),
			array( value => 1250,      label => '$1,250' ),
			array( value => 1500,      label => '$1,500' ),
			array( value => 1750,      label => '$1,750' ),
			array( value => 2000,      label => '$2,000' ),
			array( value => 3000,      label => '$3,000' ),
			array( value => 4000,      label => '$4,000' ),
			array( value => 5000,      label => '$5,000' ),
			array( value => 6000,      label => '$6,000' ),
			array( value => 7000,      label => '$7,000' ),
			array( value => 8000,      label => '$8,000' ),
			array( value => 9000,      label => '$9,000' ),
			array( value => 10000,     label => '$10,000' ),
			array( value => 20000,     label => '$20,000' ),
			array( value => 30000,     label => '$30,000' ),
			array( value => 40000,     label => '$40,000' ),
			array( value => 50000,     label => '$50,000' ),
			array( value => 60000,     label => '$60,000' ),
			array( value => 70000,     label => '$70,000' ),
			array( value => 75000,     label => '$75,000' ),
			array( value => 80000,     label => '$80,000' ),
			array( value => 85000,     label => '$85,000' ),
			array( value => 90000,     label => '$90,000' ),
			array( value => 95000,     label => '$95,000' ),
			array( value => 100000,    label => '$100,000' ),
			array( value => 110000,    label => '$110,000' ),
			array( value => 120000,    label => '$120,000' ),
			array( value => 130000,    label => '$130,000' ),
			array( value => 140000,    label => '$140,000' ),
			array( value => 150000,    label => '$150,000' ),
			array( value => 160000,    label => '$160,000' ),
			array( value => 170000,    label => '$170,000' ),
			array( value => 180000,    label => '$180,000' ),
			array( value => 190000,    label => '$190,000' ),
			array( value => 200000,    label => '$200,000' ),
			array( value => 210000,    label => '$210,000' ),
			array( value => 220000,    label => '$220,000' ),
			array( value => 230000,    label => '$230,000' ),
			array( value => 240000,    label => '$240,000' ),
			array( value => 250000,    label => '$250,000' ),
			array( value => 260000,    label => '$260,000' ),
			array( value => 270000,    label => '$270,000' ),
			array( value => 280000,    label => '$280,000' ),
			array( value => 290000,    label => '$290,000' ),
			array( value => 300000,    label => '$300,000' ),
			array( value => 310000,    label => '$310,000' ),
			array( value => 320000,    label => '$320,000' ),
			array( value => 330000,    label => '$330,000' ),
			array( value => 340000,    label => '$340,000' ),
			array( value => 350000,    label => '$350,000' ),
			array( value => 360000,    label => '$360,000' ),
			array( value => 370000,    label => '$370,000' ),
			array( value => 380000,    label => '$380,000' ),
			array( value => 390000,    label => '$390,000' ),
			array( value => 400000,    label => '$400,000' ),
			array( value => 410000,    label => '$410,000' ),
			array( value => 420000,    label => '$420,000' ),
			array( value => 430000,    label => '$430,000' ),
			array( value => 440000,    label => '$440,000' ),
			array( value => 450000,    label => '$450,000' ),
			array( value => 460000,    label => '$460,000' ),
			array( value => 470000,    label => '$470,000' ),
			array( value => 480000,    label => '$480,000' ),
			array( value => 490000,    label => '$490,000' ),
			array( value => 500000,    label => '$500,000' ),
			array( value => 510000,    label => '$510,000' ),
			array( value => 520000,    label => '$520,000' ),
			array( value => 530000,    label => '$530,000' ),
			array( value => 540000,    label => '$540,000' ),
			array( value => 550000,    label => '$550,000' ),
			array( value => 560000,    label => '$560,000' ),
			array( value => 570000,    label => '$570,000' ),
			array( value => 580000,    label => '$580,000' ),
			array( value => 590000,    label => '$590,000' ),
			array( value => 600000,    label => '$600,000' ),
			array( value => 610000,    label => '$610,000' ),
			array( value => 620000,    label => '$620,000' ),
			array( value => 630000,    label => '$630,000' ),
			array( value => 640000,    label => '$640,000' ),
			array( value => 650000,    label => '$650,000' ),
			array( value => 660000,    label => '$660,000' ),
			array( value => 670000,    label => '$670,000' ),
			array( value => 680000,    label => '$680,000' ),
			array( value => 690000,    label => '$690,000' ),
			array( value => 700000,    label => '$700,000' ),
			array( value => 710000,    label => '$710,000' ),
			array( value => 720000,    label => '$720,000' ),
			array( value => 730000,    label => '$730,000' ),
			array( value => 740000,    label => '$740,000' ),
			array( value => 750000,    label => '$750,000' ),
			array( value => 760000,    label => '$760,000' ),
			array( value => 770000,    label => '$770,000' ),
			array( value => 780000,    label => '$780,000' ),
			array( value => 790000,    label => '$790,000' ),
			array( value => 800000,    label => '$800,000' ),
			array( value => 810000,    label => '$810,000' ),
			array( value => 820000,    label => '$820,000' ),
			array( value => 830000,    label => '$830,000' ),
			array( value => 840000,    label => '$840,000' ),
			array( value => 850000,    label => '$850,000' ),
			array( value => 860000,    label => '$860,000' ),
			array( value => 870000,    label => '$870,000' ),
			array( value => 880000,    label => '$880,000' ),
			array( value => 890000,    label => '$890,000' ),
			array( value => 900000,    label => '$900,000' ),
			array( value => 910000,    label => '$910,000' ),
			array( value => 920000,    label => '$920,000' ),
			array( value => 930000,    label => '$930,000' ),
			array( value => 940000,    label => '$940,000' ),
			array( value => 950000,    label => '$950,000' ),
			array( value => 960000,    label => '$960,000' ),
			array( value => 970000,    label => '$970,000' ),
			array( value => 980000,    label => '$980,000' ),
			array( value => 990000,    label => '$990,000' ),
			array( value => 1000000,   label => '$1,000,000' ),
			array( value => 1100000,   label => '$1,100,000' ),
			array( value => 1200000,   label => '$1,200,000' ),
			array( value => 1300000,   label => '$1,300,000' ),
			array( value => 1400000,   label => '$1,400,000' ),
			array( value => 1500000,   label => '$1,500,000' ),
			array( value => 1600000,   label => '$1,600,000' ),
			array( value => 1700000,   label => '$1,700,000' ),
			array( value => 1800000,   label => '$1,800,000' ),
			array( value => 1900000,   label => '$1,900,000' ),
			array( value => 2000000,   label => '$2,000,000' ),
			array( value => 2500000,   label => '$2,500,000' ),
			array( value => 3000000,   label => '$3,000,000' ),
			array( value => 3500000,   label => '$3,500,000' ),
			array( value => 4000000,   label => '$4,000,000' ),
			array( value => 4500000,   label => '$4,500,000' ),
			array( value => 5000000,   label => '$5,000,000' ),
			array( value => 6000000,   label => '$6,000,000' ),
			array( value => 8000000,   label => '$8,000,000' ),
			array( value => 10000000,  label => '$10,000,000' )
		);
	}
	
	
	/**
	 * This method gets an array of Bedroom data.  This data is used for drop down lists in the 
	 * quick search and admin forms.
	 * 
	 * @return  array  An array of associative arrays containing price data.  Each associative array 
	 *                 contains a 'value' key and a 'label' key.
	 * 
	 */
	public function getBedData ()
	{
		return array(
			array( value => 1,  label => '1' ),
			array( value => 2,  label => '2' ),
			array( value => 3,  label => '3' ),
			array( value => 4,  label => '4' ),
			array( value => 5,  label => '5' ),
			array( value => 6,  label => '6' ),
			array( value => 7,  label => '7' )
		);
	}
	
	
	/**
	 * This method gets an array of Bathroom data.  This data is used for drop down lists in the 
	 * quick search and admin forms.
	 * 
	 * @return  array  An array of associative arrays containing price data.  Each associative array 
	 *                 contains a 'value' key and a 'label' key.
	 * 
	 */
	public function getBathData ()
	{
		return array(
			array( value => 1,  label => '1' ),
			array( value => 2,  label => '2' ),
			array( value => 3,  label => '3' ),
			array( value => 4,  label => '4' ),
			array( value => 5,  label => '5' ),
			array( value => 6,  label => '6' ),
			array( value => 7,  label => '7' )
		);
	}
	
	
	/**
	 * This method gets an array of Listing Owner Type data.  This data is used for drop down lists 
	 * in admin forms.
	 * 
	 * @return  array  An array of associative arrays containing price data.  Each associative array 
	 *                 contains a 'value' key and a 'label' key.
	 * 
	 */
	public function getOwnerTypeData ()
	{
		return array( 
			array( value =>'agent_broker',  label => 'Agent Then Broker' ),
			array( value =>'agent',         label => 'Agent Only' ),
			array( value =>'broker',        label => 'Broker Only' )
			);
	}
	
	
	/* PRIVATE METHODS ************************************************************************** */
	
	/**
	 * This method established the URL parameters to be sent to the remote web service and sends the 
	 * URL to the Data Service object and injects the resulting data into the DAO. This method 
	 * contains general configurations and accepts a Web Service URL object as an argument which can 
	 * contain more specific configuration.
	 * 
	 * @param   com_ajmichels_wppf_data_webServiceUrl  $wsu  A reference to a web service url object.
	 * @return  void
	 * 
	 */
	private function setData ( com_ajmichels_wppf_data_webServiceUrl &$wsu = null )
	{
		
		if ( $wsu == null ) {
			$wsu = $this->getWebServiceUrl();
		}
		
		$wsu->setCacheSetting( 15 );
		
		$data = $this->getDataService()->getData( $wsu );
		
		/* Currently the Disclaimer data comes through as a sibling element within the web service
		 * request. To ensure this data is available when a set of listings is called we check for 
		 * the disclaimers existance and then insert it as a property for each listing. Ideally this 
		 * would be retrieved via a separate service request but this would probably results it some 
		 * messy and confusing code or an additional http request.
		 * 
		 * NOTE: We have already discussed breaking this out as a separate API request which we can 
		 * then cache for a much longer period (24 hours)
		 */
		if ( array_key_exists( 'disclaimer', $data ) ) {
			
			foreach ( $data['listings'] as &$listing ) {
				$listing['disclaimer'] = $data['disclaimer'];
			}
			
		}
		
		$this->getDAO()->setData( $data['listings'] );
	}
	
	
	/**
	 * This method establishes specific URL parameters for featured listings and then forwards the 
	 * URL Object on to the more general setData method.
	 * 
	 * @param   string   $owner_type  The type of data that should be returned 'agent_broker', 
	 *                                'agent', or 'broker'.
	 * @param   numeric  $maxResults  The maximum number of listings which can be returned from the 
	 *                                web service request. The cap is 50.
	 * @return  void
	 * 
	 */
	private function setFeaturedListingsData ( $owner_type, $maxResults )
	{
		$wsu = $this->getWebServiceUrl();
		$wsu->setScriptPath( '/propertyBar/' 
		                     . $this->getOptionManager()->getOptionValueFromWP( 'wolfnet_productKey' ) );
		$wsu->setParameter( 'owner_type',  $owner_type );
		$wsu->setParameter( 'max_results', $maxResults );
		$this->setData( $wsu );
	}
	
	
	/**
	 * This method establishes specific URL parameters for grid listings and then forwards the 
	 * URL Object on to the more general setData method.
	 * 
	 * @param   numeric  $minPrice    The minimum price for listings which can be returned.
	 * @param   numeric  $maxPrice    The maximum price for listings which can be returned.
	 * @param   string   $city        The name of a city to limit listing results to.
	 * @param   string   $zipcode     The zipcode to limit listing results to.
	 * @param   string   $owner_type  The type of data that should be returned 'agent_broker', 
	 *                                'agent', or 'broker'.
	 * @param   numeric  $maxResults  The maximum number of listings which can be returned from the 
	 *                                web service request. The cap is 50.
	 * @return  void
	 * 
	 */
	private function setGridListingData ( $minPrice, $maxPrice, $city, $zipcode, $owner_type, $maxResults )
	{
		$wsu = $this->getWebServiceUrl();
		$wsu->setScriptPath( '/propertyGrid/' 
		                     . $this->getOptionManager()->getOptionValueFromWP( 'wolfnet_productKey' ) );
		if ( $minPrice != '' ) {
			$wsu->setParameter( 'min_price', $minPrice );
		}
		if ( $maxPrice != '' ) {
			$wsu->setParameter( 'max_price', $maxPrice );
		}
		if ( $city != '' ) {
			$wsu->setParameter( 'city',      $city );
		}
		if ( $zipcode != '' ) {
			$wsu->setParameter( 'zip_code',  $zipcode );
		}
		$wsu->setParameter( 'owner_type',  $owner_type );
		$wsu->setParameter( 'max_results', $maxResults );
		$this->setData( $wsu );
	}
	
	
	/* ACCESSOR METHODS ************************************************************************* */
	
	/**
	 * GETTER: This method is a getter for the dataService property.
	 * 
	 * @return  com_ajmichels_wppf_data_service
	 * 
	 */
	public function getDataService ()
	{
		return $this->dataService;
	}
	
	
	/**
	 * SETTER: This method is a setter for the dataService property.
	 * 
	 * @param   com_ajmichels_wppf_data_service  $service
	 * @return  void
	 * 
	 */
	public function setDataService ( com_ajmichels_wppf_data_service $service )
	{
		$this->dataService = $service;
	}
	
	
	/**
	 * GETTER: This method is a getter for the webServiceUrl property.
	 * 
	 * @return  com_ajmichels_wppf_data_webServiceUrl
	 * 
	 */
	public function getWebServiceUrl ()
	{
		return $this->webServiceUrl;
	}
	
	
	/**
	 * SETTER: This method is a setter for the webServiceUrl property.
	 * 
	 * @param   com_ajmichels_wppf_data_webServiceUrl  $url
	 * @return  void
	 * 
	 */
	public function setWebServiceUrl ( com_ajmichels_wppf_data_webServiceUrl $url )
	{
		$this->webServiceUrl = $url;
	}
	
	
	/**
	 * GETTER: This method is a getter for the optionManager property.
	 * 
	 * @return  com_ajmichels_wppf_option_manager
	 * 
	 */
	public function getOptionManager ()
	{
		return $this->optionManager;
	}
	
	
	/**
	 * SETTER: This method is a setter for the optionManager property.
	 * 
	 * @param   com_ajmichels_wppf_option_manager  $manager
	 * @return  void
	 * 
	 */
	public function setOptionManager ( com_ajmichels_wppf_option_manager $manager )
	{
		$this->optionManager = $manager;
	}
	
	
}