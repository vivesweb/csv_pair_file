<?php

/** csv_pair_file Example file
 *  
 * Class for manage csv pair files
 * 
 * Used normally for Neural Networks, Deep learning, Machine learning, Intelligence Artificial, ....
 *
 * 
 * 
 * @author Rafael Martin Soto
 * @author {@link http://www.inatica.com/ Inatica}
 * @since July 2021
 * @version 1.0.0
 * @license GNU General Public License v3.0
*/


require_once( 'csv_pair_file_class.php' ); // For manage csv files

$csv_original_dataset = new csv_pair_file('original_dataset.csv', 'desired_dataset.csv');


echo 'Randomize original and desired Datasets'.PHP_EOL;

$csv_original_dataset->randomize();

$perc_Train = 70;
$perc_rest_Test = 50;

echo 'Splitting Randomized Dataset in '.$perc_Train.'% for Train and '.(100-$perc_Train).'% for Test & Validation'.PHP_EOL;

$RandomizedName 	= $csv_original_dataset->get_csv_randomized_file_names();

$csv = new csv_pair_file( $RandomizedName[0], $RandomizedName[1] );
$SplittedNames = $csv->split( $perc_Train );


// We have New Train & Desired Data File...
$csv_train_dataset 	= new csv_pair_file( $SplittedNames[0][0], $SplittedNames[0][1] );


// The rest will need to splitted in 2 parts (Test & Validation data)
echo 'Splitting Rest '.(100-$perc_Train).'% Dataset in 2 files of '.$perc_rest_Test.'% for Test and '.(100-$perc_rest_Test).'% for Validation'.PHP_EOL;

$csv = new csv_pair_file( $SplittedNames[1][0], $SplittedNames[1][1] );
$SplittedNames = $csv->split( $perc_rest_Test ); // new csv is perc_rest_Test% of the global data (100% - 70% = 30%) . Split it at 50% (80% + 15% + 15% = 100%)

// We have  Test & Validation New Data Files
$this->csv_test_dataset       			= new csv_pair_file( $SplittedNames[0][0], $SplittedNames[0][1] );
$this->csv_validation_dataset 			= new csv_pair_file( $SplittedNames[1][0], $SplittedNames[1][1] );

?>
