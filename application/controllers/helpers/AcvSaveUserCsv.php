<?php 

/**
 * Class Controller Helper for saving the info uploaded by the user in csv format
 * = hce_project_upload_file() from H2C
 */
class Zend_Controller_Action_Helper_AcvSaveUserCsv extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvSaveUserCsv($username, array $data, $projectId) 
    {
    	$filename = Zend_Registry::get('config')->paths->backend->csvs . '/' . $username . '_project_' . $projectId . '.csv';    	

		if(!($fp = fopen($filename, 'w'))) {		
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('File open failed.'));		
		} else {

			// headers MATERIALES		    			
		    fputcsv($fp, 
					array(
		    			'MATERIAL BASICO',
		    			'UNIDAD DE OBRA',
		    			'SUBCAPITULO',
		    			'CAPITULO'
		    		)
		    );
		    // subheaders MATERIALES		
		    fputcsv($fp,
			    array(
				    'CODIGO',
				    'ud',
				    'NOMBRE MATERIAL',
				    'CANTIDAD',
				    'PRECIO',
				    'IMPORTE',
				    'CODIGO',
				    'ud',
				    'NOMBRE',
				    'CANTIDAD',
				    'CODIGO',
				    'NOMBRE',
				    'CODIGO',
				    'NOMBRE'
				)
			);	    
			for ($x = 0; $x < count($data['materiales']); $x++) {
				fputcsv($fp, 
					array(
						$data['materiales'][$x][0], 
						$data['materiales'][$x][1], 
						$data['materiales'][$x][2], 
						$data['materiales'][$x][3],					    		
						$data['materiales'][$x][6],
						$data['materiales'][$x][7],
						$data['materiales'][$x][8],
						$data['materiales'][$x][9],
						$data['materiales'][$x][10],
						$data['materiales'][$x][11],
						$data['materiales'][$x][12],
						$data['materiales'][$x][13],
					)
				);    
			}

			// Headers Maquinaria
			fputcsv($fp,
			    array(
					'MAQUINARIA',
					'UNIDAD DE OBRA',
					'SUBCAPITULO',
					'CAPITULO'
				)
			);

			// Subheaders Maquinaria
			fputcsv($fp,
			    array(
					'CODIGO',
					'ud',
					'NOMBRE MAQUINARIA',
					'CANTIDAD',
					'PRECIO',
					'IMPORTE',
					'CODIGO',
					'ud',
					'NOMBRE',
					'CANTIDAD',
					'CODIGO',
					'NOMBRE',
					'CODIGO',
					'NOMBRE'
				)
			);		

			for ($x = 0; $x < count($data['maquinaria']); $x++) {
				fputcsv($fp, 
					array(
						$data['maquinaria'][$x][0], 
						$data['maquinaria'][$x][1], 
						$data['maquinaria'][$x][2], 
						$data['maquinaria'][$x][3],					    		
						$data['maquinaria'][$x][6],
						$data['maquinaria'][$x][7],
						$data['maquinaria'][$x][8],
						$data['maquinaria'][$x][9],
						$data['maquinaria'][$x][10],
						$data['maquinaria'][$x][11],
						$data['maquinaria'][$x][12],
						$data['maquinaria'][$x][13],
					)
				);    
			}

			//Cabececeras tabla Mano de obra
			fputcsv($fp, 
					array(
						'MANO DE OBRA',
						'UNIDAD DE OBRA',
						'SUBCAPITULO',
						'CAPITULO'
					)
			);			

			//Subcabeceras tabla Mano de obra
			fputcsv($fp, 
					array(
						'CODIGO',
						'ud',
						'NOMBRE MANO DE OBRA',
						'CANTIDAD',
						'PRECIO',
						'IMPORTE',
						'CODIGO',
						'ud',
						'NOMBRE',
						'CANTIDAD',
						'CODIGO',
						'NOMBRE',
						'CODIGO',
						'NOMBRE'
					)	
			);			

			for ($x = 0; $x < count($data['mano_de_obra']); $x++) {
				fputcsv($fp, 
					array(
						$data['mano_de_obra'][$x][0], 
						$data['mano_de_obra'][$x][1], 
						$data['mano_de_obra'][$x][2], 
						$data['mano_de_obra'][$x][3],					    		
						$data['mano_de_obra'][$x][6],
						$data['mano_de_obra'][$x][7],
						$data['mano_de_obra'][$x][8],
						$data['mano_de_obra'][$x][9],
						$data['mano_de_obra'][$x][10],
						$data['mano_de_obra'][$x][11],
						$data['mano_de_obra'][$x][12],
						$data['mano_de_obra'][$x][13],
					)
				);    
			}

			fclose($fp);		
		}
		return $filename;		
    }

    public function direct($username, $info, $projectId)
    {
        return $this->getAcvSaveUserCsv($username, $info, $projectId);
    }
}    