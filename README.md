# Manage CSV Train Datasets and Desired values in PHP for Machine Learning
Manage csv pair files for Machine Learning


 ## WHAT DO THIS LIBRARY IN PURE PHP OF CSV MANAGEMENT FOR ARTIFICIAL INTELLIGENCE?:
It is a library for manage csv data files. In Machine learning (deep learning) we need to give to Neural Networks a lot of datasets that need to be compared with desired values. This library helps to manage this datasets. You can to randomize given data and desired data maintaining the correspondence of values, split data into 2 files more (for train & test), and you can split another time test data (for test and validation). It makes files in /tmp dir, but you can change it where you need. 100% written in PHP (pure PHP). Easy to use on any type of server. You can use it freely and working without install any package more. With the default configuration of your server, this code can be used in your shared hosting server, for example, as simple as that :smiley:

No more easy use is possible. You only need to include a master file .php as... **_require_once( 'csv_pair_file_class.php' );_**. You have an example.php file for test it.


 # REQUERIMENTS:
 
 - A minimum (minimum, minimum, minimum requeriments is needed). Tested on:
 		
    - Simple Raspberry pi (B +	512MB	700 MHz ARM11) with Raspbian Lite PHP7.3 (i love this gadgets)  :heart_eyes:
 		
    - VirtualBox Ubuntu Server 20.04.2 LTS (Focal Fossa) with PHP7.4.3
 
 
  # FILES:
 *csv_pair_file_class.php* -> **Main File**.
 
 
 # INSTALLATION:
 A lot of easy :smiley:. It is written in PURE PHP. Only need to include the files. Tested on basic PHP installation
 
         require_once( 'csv_pair_file_class.php' );
 
 
# RESUME OF METHODS:

- **CREATE CSV PAIR OBJECT:**
 
*$csv_pair = new csv_pair_file( $csv_file_name, $csv_pair_file_name );*

Example:

        $csv_pair = new csv_pair_file( 'master_dataset.csv", 'desired_values_dataset.csv' );



- **SET CSV PAIR FILE NAMES:**

*$csv_pair->set_file_csv( $csv_file_name, $csv_pair_file_name );*

You can give the names in the moment on create the object class, but if you don't given the field names, you can set it later with this method.

Example:

        $csv_pair->set_file_csv( 'master_dataset.csv", 'desired_values_dataset.csv' );
	
	
- **RANDOMIZE CSV ROWS:**

*$csv_pair->randomize( $new_file_name_randomized = null, $new_pair_file_name_randomized = null );*

This method randomize the order in original $csv_file_name & csv_pair_file_name, but in both files the randomized new number of row will remain in correct correspondence between first randomized file and second randomized file. If not new names of files given, the system will create new files and store the names in the class. You can get this names later. This functions returns an array of the 2 new filenames.

Example:

        $csv_pair->randomize( );



- **SPLIT EACH CSV (MASTER AND PAIR) IN 2 FILES BY %:**

*$csv_pair->split( $perc_remains_first_file = 80 );*

   * First file created with first part of percentage.
   
   * Second file created with the rest of percentage
   
   * This one is repeated for pair file.
	 
   * Param means the percentage with original file remains.
   
   * For example split( 80 ) means that the first file will have 80% of data, and the second file will be created with the rest of 20% data
   
   * return array $csv_splitted_file_names
   
   * $csv_splitted_file_names[0][0]: Filename First part csv splitted
   
   * $csv_splitted_file_names[0][1]: Pair Filename First part csv splitted
   
   * $csv_splitted_file_names[1][0]: Filename Second part csv splitted
  
   * $csv_splitted_file_names[1][1]: Pair Filename Second part csv splitted

Example:

        $FieldNames = $csv_pair->split( 70 );
	
        echo $FieldNames[0][0];
        echo $FieldNames[0][1];
        echo $FieldNames[1][0];
        echo $FieldNames[1][1];



- **GET NUM ROWS:**

*$csv_pair->get_num_rows( );*

Get the number of rows in primary .csv file (Second file expects to have the same number of rows).
Example:

        echo $csv_pair->get_num_rows( );
	

- **GET NAME MASTER FILE:**

*$csv_pair->get_csv_file_name( );*

Get the File Name of Master File.
Example:

        echo $csv_pair->get_csv_file_name( );



- **GET NAME PAIR FILE:**

*$csv_pair->get_csv_pair_file_name( );*

Get the File Name of Paired File.
Example:

        echo $csv_pair->get_csv_pair_file_name( );




- **GET AN ARRAY OF FILE NAMES OF RANDOMIZED FIELDS CREATED WITH randomize() METHOD:**

*$csv_pair->get_csv_randomized_file_names( )*

Example:

    $RandomizedFieldNames = $csv_pair->get_csv_randomized_file_names( );
    echo $RandomizedFieldNames[0]; // Master Randomized File
    echo $RandomizedFieldNames[1]; // Pair Randomized File





- **GET THE FILE NAMES OF SPLITTED FIELDS CREATED WITH split() METHOD:**

*$csv_pair->get_csv_splitted_file_names( )*

return array $csv_splitted_file_names

$csv_splitted_file_names[0][0]: Filename First part csv splitted

$csv_splitted_file_names[0][1]: Pair Filename First part csv splitted

$csv_splitted_file_names[1][0]: Filename Second part csv splitted

$csv_splitted_file_names[1][1]: Pair Filename Second part csv splitted

Example:

        $FieldNames = $csv_pair->get_csv_splitted_file_names( );
        echo $FieldNames[0][0];
        echo $FieldNames[0][1];
        echo $FieldNames[1][0];
        echo $FieldNames[1][1];

 
 **Of course. You can use it freely :vulcan_salute::alien:**
 
 By Rafa.
 
 
 @author Rafael Martin Soto
 
 @author {@link http://www.inatica.com/ Inatica}
 
 @since July 2021
 
 @version 1.0.0
 
 @license GNU General Public License v3.0

