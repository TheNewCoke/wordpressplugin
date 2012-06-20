<?php

/**
 * This is the listingGridWidget object. This object inherites from the base WP_Widget object and 
 * defines the display and functionality of this specific widget.
 * 
 * @see http://codex.wordpress.org/Widgets_API
 * @see http://core.trac.wordpress.org/browser/tags/3.3.2/wp-includes/widgets.php
 * 
 * @package       com.mlsfinder.wordpress
 * @subpackage    listing
 * @title         listingGridWidget.php
 * @extends       com_mlsfinder_wordpress_abstract_widget
 * @contributors  AJ Michels (aj.michels@wolfnet.com)
 * @version       1.0
 * @copyright     Copyright (c) 2012, WolfNet Technologies, LLC
 * 
 */

class com_mlsfinder_wordpress_listing_listingGridWidget
extends com_mlsfinder_wordpress_abstract_widget
{
	
	
	/* PROPERTIES ******************************************************************************* */
	
	/**
	 * This property holds an array of different options that are available for each widget instance.
	 *
	 * @type  array
	 * 
	 */
	public $options = array( 
		'min_price'   => '', 
		'max_price'   => '', 
		'city'        => '', 
		'zipcode'     => '', 
		'agentBroker' => '', 
		'maxResults'  => 50 
		);
	
	public $controls = array(
		'width' => '300px'
		);
	
	private $listingService;
	private $listingGridView;
	private $listingGridOptionsView;
	
	
	/* CONSTRUCTOR ****************************************************************************** */
	
	/**
	 * This constructor method passes some key information up to the parent classes and eventionally 
	 * the information gets registered with the WordPress application.
	 *
	 * @return  void
	 * 
	 */
	public function __construct ()
	{
		parent::__construct( 'mlsFinder_listingGridWidget', 'MLS Finder Listing Grid' );
		/* The 'sf' property is set in the abstract widget class and is pulled from the plugin instance */
		$this->setListingService( $this->sf->getBean( 'ListingService' ) );
		$this->setListingGridView( $this->sf->getBean( 'ListingGridView' ) );
		$this->setListingGridOptionsView( $this->sf->getBean( 'ListingGridOptionsView' ) );
	}
	
	
	/* PUBLIC METHODS *************************************************************************** */
	
	/**
	 * This method is the primary output for the widget. This is the information the end user of the 
	 * site will see.
	 * 
	 * @param   array  $args      An array of arguments passed to a widget.
	 * @param   array  $instance  An array of widget instance data
	 * @return  void
	 * 
	 */
	public function widget ( $args, $instance )
	{
		$options = $this->getOptionData( $instance );
		$gridListings = $this->getListingService()->getGridListings(
			$options['maxPrice']['value'],
			$options['minPrice']['value'],
			$options['city']['value'],
			$options['zipcode']['value'],
			$options['agentBroker']['value'],
			$options['maxResults']['value']
			);
		$data = array(
			'listings' => $gridListings,
			'options'  => $options
			);
		$this->getListingGridView( $data )->out( $data );
	}
	
	
	/**
	 * This method is responsible for display of the widget instance form which allows configuration
	 * of each widget instance in the WordPress admin.
	 * 
	 * @param   array  $instance  An array of widget instance data
	 * @return  void
	 * 
	 */
	public function form ( $instance )
	{
		$ls = $this->getListingService();
		$data = array(
			'fields' => $this->getOptionData( $instance ),
			'prices' => $ls->getPriceData()
			);
		$this->getListingGridOptionsView()->out( $data );
	}
	
	
	/**
	 * This method is responsible for saving any data that comes from the widget instance form.
	 * 
	 * @param   array  $new_instance  An array of widget instance data from after the form submit
	 * @param   array  $old_instance  An array of widget instance data from before the form submit
	 * @return  array                 An array of data that needs to be saved to the database.
	 * 
	 */
	public function update ( $new_instance, $old_instance )
	{
		// processes widget options to be saved
		$newData = $this->getOptionData( $new_instance );
		$saveData = array();
		foreach ( $newData as $opt => $data ) {
			$saveData[$opt] = strip_tags( $data['value'] );
		}
		return $saveData;
	}
	
	
	/* ACCESSORS ******************************************************************************** */
	
	public function getListingService ()
	{
		return $this->listingService;
	}
	
	
	public function setListingService ( com_mlsfinder_wordpress_listing_service $service )
	{
		$this->listingService = $service;
	}
	
	
	public function getListingGridView ()
	{
		return $this->listingGridView;
	}
	
	
	public function setListingGridView ( com_ajmichels_wppf_interface_iView $view )
	{
		$this->listingGridView = $view;
	}
	
	
	public function getListingGridOptionsView ()
	{
		return $this->listingGridOptionsView;
	}
	
	
	public function setListingGridOptionsView ( com_ajmichels_wppf_interface_iView $view )
	{
		$this->listingGridOptionsView = $view;
	}
	
	
}