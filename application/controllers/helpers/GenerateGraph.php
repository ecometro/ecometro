<?php
/**
 * Documentation Block Here
 */
class Zend_Controller_Action_Helper_GenerateGraph extends Zend_Controller_Action_Helper_Abstract
{		
    /**
     * Generates radar graphic
     * @param  string $username [description]
     * @param  int $project  [description]
     * @param  array  $data     [description]
     * @param  int $width    [description]
     * @param  int $height   [description]
     * @param  string $type     [description]
     * @param  int $fontsize [description]
     * @return void           [description]
     */
    public function getGenerateGraph($username, $project, array $data, $width, $height, $type, $fontsize)
    {
	
    	/* Prepare some nice data & axis config */ 
		$projectData = new pData();   
		$projectData->addPoints($data, 'ScoreA'); 
		$projectData->setSerieDescription('ScoreA', 'Application A');
		$projectData->setPalette('ScoreA', array('R' => 209, 'G' => 62, 'B' => 72));
				
		/**
		 * r - Relación con el entorno
		 * m - Materiales Bioconstrucción
		 * d - Diseño Bioclimático
		 * a - Gestión del Agua
		 * e - Energías Renovables
		 */			
		$projectData->addPoints(array('d', 'a', 'e', 'r', 'm'), 'Labels');
		$projectData->setAbscissa('Labels');
		
		/* Create the pChart object */
		$photo = new pImage($width, $height, $projectData);								
		
		/* Define general drawing parameters */
		$photo->setFontProperties(array('FontName' => APPLICATION_PATH . '/../library/pChart/fonts/Forgotte.ttf', 'FontSize' => $fontsize, 'R' => 209, 'G' => 62, 'B' => 72));						
		
		/* Create the radar object */
		$splitChart = new pRadar();		
		
		/* Draw the 1st radar chart */
		$photo->setGraphArea(0, 0, $width, $height);		
		
		$options = array(
			'Layout' => RADAR_LAYOUT_STAR,			
			'AxisRotation' => 55,
			'PointRadius' => 1,
			'LabelsBackground' => FALSE,
			'DrawAxisValues' => FALSE,
			'SegmentHeight' => 2,
			'Segments' => 5,	
			'PolyAlpha' => 30,
			'WriteValues' => FALSE,
			'ValueFontSize' => 8,
			'DrawPoly' => TRUE,
			'DrawTicks' => TRUE,
			'DrawBackground' => FALSE,		
			'LabelPos' => RADAR_LABELS_HORIZONTAL,
			'AxisR' => 51, 
			'AxisG' => 180, 
			'AxisB' => 76, 
			'AxisAlpha' => 100,			
			'TicksLength' => 0,
			'LabelPadding' => 2,				
		);
		
    	$splitChart->drawRadar($photo, $projectData, $options);		
		
		/* Render the picture */
		$username . '_graph_' . $project . '.png';
		
    	$photo->Render(Zend_Registry::get('config')->paths->backend->images->graphs . "/" . $username . '_graph_' . $project . '_' . $type . '.png');
    	
    }
    
    /**
     * Strategy pattern: call helper as broker method
     * @param  [type] $username [description]
     * @param  [type] $project  [description]
     * @param  [type] $data     [description]
     * @param  [type] $width    [description]
     * @param  [type] $height   [description]
     * @param  [type] $type     [description]
     * @param  [type] $fontsize [description]
     * @return [type]           [description]
     */
    public function direct($username, $project, $data, $width, $height, $type, $fontsize)
    {
        return $this->getGenerateGraph($username, $project, $data, $width, $height, $type, $fontsize);
    }
}
