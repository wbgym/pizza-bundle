<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Table tl_pizza
 */
$GLOBALS['TL_DCA']['tl_pizza'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('user','size'),
			'panelLayout'             => 'filter;search,limit',
		),
		'label' => array(
			'showColumns'			  => true,
			'fields'				  => array('user','size','thin'),
			'label_callback'		  => array('tl_pizza','generateLabels')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pizza']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pizza']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pizza']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pizza']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pizza']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{user_legend},user;{pizza_legend},size,zutaten,thin'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pizza']['size'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'				  => array('children','small','medium','large','jumbo','party'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_pizza']['size_labels'],
			'eval'                    => array('mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'zutaten' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pizza']['zutaten'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'checkboxWizard',
			'options'				  => array('salami','peperonisalami','mozzarella','champignons','basilikum','paprika','oliven','feta'),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_pizza']['zutaten_labels'],
			'eval'                    => array('multiple'=>true,'tl_class'=>'w50'),
			'sql'                     => "blob NULL"
		),
		'thin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pizza']['thin'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'user' => array
		(
			'label'					  => &$GLOBALS['TL_LANG']['tl_pizza']['user'],
			'exclude'				  => true,
			'search'				  => true,
			'inputType'				  => 'select',
			'options_callback'		  => array('tl_pizza','memberList'),
			'foreignKey'			  => 'tl_member.username',
			'sql'					  => "varchar(255) NOT NULL default ''"
		)
	)
);

class tl_pizza extends Backend {
	
	//Fetch frontend members for select field
	public function memberList() {
		$members = $this->Database->prepare("SELECT id, firstname, lastname FROM tl_member")
									->execute();
		
		while($arrMember = $members->fetchAssoc()) {
			$arrMembers[$arrMember['id']] = $arrMember['firstname'] . ' ' . $arrMember['lastname'];
		}
		
		return $arrMembers;
	}
	
	//Generate labels for list view
	public function generateLabels($row, $label, DataContainer $dc, $args) {
		$user = $this->Database->prepare("SELECT firstname,lastname FROM tl_member WHERE id = ?")
				->execute($row['user']);
		$arrUser = $user->fetchAssoc();
		
		$args[0] = $arrUser['firstname'] . ' ' . $arrUser['lastname'];
		
		return $args;
	}
}
