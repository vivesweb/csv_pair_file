<?php
/** csv_pair_file
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
 * 
 * @param string $csv_file_name
 * @param string $csv_pair_file_name
*/

class csv_pair_file
{
    private $csv_file_name	= null;
	private $csv_pair_file_name	= null;
    private $csv_randomized_file_names	= array();
    private $csv_splitted_file_names	= array(); // [0] will be first part of data splitted and [1] the rest
    private $num_rows		= 0;
    private $Spl			= null;
    private $Spl_pair		= null;
    private $TimeTokenized	= null; // Used for name folder tmp files

	
    public function __construct( $csv_file_name = null,  $csv_pair_file_name = null ) {
    	if( isset($csv_file_name) && isset($csv_pair_file_name) ){
        	$this->set_file_csv( $csv_file_name,  $csv_pair_file_name );
        }
	} // / __construct
    
    
    
	/**
	 * Set File Name & Init Spl & Num Rows
	 */
	
    public function set_file_csv( $csv_file_name, $csv_pair_file_name ) {
        $this->csv_file_name 	= $csv_file_name;
        $this->csv_pair_file_name 	= $csv_pair_file_name;
        
        // Create a new file reference using SplFileObject:
        $this->Spl 				= new SplFileObject( $this->csv_file_name, 'r' );
		$this->Spl_pair			= new SplFileObject( $this->csv_pair_file_name, 'r' );
        
        // Set Num Rows
        $this->set_num_rows( );
        
        $this->TimeTokenized	= time(); // Used for name folder tmp files
	} // / set_file_csv()
    
    
    
    
    
    
	/**
	 * Randomize order of csv data
     *
     * return array $new_file_names 
	 */
	
    public function randomize( $new_file_name_randomized = null, $new_pair_file_name_randomized = null ) {
		// We use fgets(). More faster than fgetcsv()
		ini_set("auto_detect_line_endings", true); // Best performance with special chars in fgets()

		if( !isset($new_file_name_randomized) ){
        	$path = '/tmp/'.$this->TimeTokenized.'/';
            
            if (!file_exists($path)) {
                mkdir($path);
            }
			
			$csv_name_parsed = str_replace('.csv', '', basename($this->csv_file_name) ); // Only works with lowercase file names!!!!
            
        	$new_file_name_randomized 		= $path.$csv_name_parsed.'_randomized_'.$this->TimeTokenized.'.csv';
			$new_pair_file_name_randomized 	= $path.$csv_name_parsed.'_randomized_pair_'.$this->TimeTokenized.'.csv';
			
			unset( $csv_name_parsed );
			unset( $path );
        }
        
        $Spl			= $this->Spl;
		$Spl_pair		= $this->Spl_pair;

		$Spl->rewind();	// Ensure to go at first row
		$Spl_pair->rewind();	// Ensure to go at first row

        $SplShuffled 		= new SplFileObject( $new_file_name_randomized, 'w' );
        $SplPairShuffled 	= new SplFileObject( $new_pair_file_name_randomized, 'w' );
        

		// Randomize array of numbers
        $numbers = range( 0, ($this->num_rows-1) );
        shuffle($numbers);

		
        $i=0;
        foreach ($numbers as $number) {
			++$i;
			
			$Spl->seek($number);
			$Spl_pair->seek($number);
				
			try{
				$Str 		= $Spl->fgets();
				$StrPair 	= $Spl_pair->fgets();
			} catch (Exception $e) {
				// With some special chars, fgets function throw an exception. Try then with fgetcsv (more slowly but improve performance)
				
				$Spl->seek($number);
				$Spl_pair->seek($number);
				$Str 		= $Spl->fgetcsv();
				$StrPair 	= $Spl_pair->fgetcsv();
			}

			$SplShuffled->fwrite( $Str );
			$SplPairShuffled->fwrite( $StrPair );
        }
    	// Close Shuffled CSV
        $SplShuffled = null;
        $SplPairShuffled = null;
		
		unset( $SplShuffled );
		unset( $SplPairShuffled );
		unset( $i );
		unset( $numbers );

		$new_file_names = [];

		$new_file_names[] = $new_file_name_randomized;
		$new_file_names[] = $new_pair_file_name_randomized;

		$this->csv_randomized_file_names = $new_file_names;
        
        return $new_file_names;
	} // / randomize()




	
    
    
    
    
    
    
	/**
	 * Split csv file in 2 csv files.
	 * 
	 * First file created with first part of percentage.
	 * Second file created with the rest of percentage
	 * 
	 * Param means the percentage with original file remains.
	 * For example split( 80 ) means that the first file will have 80% of data, and the second file will be created with the rest of 20% data
     *
     * @param float $perc_remains_first_file
	 * 
	 * return array $csv_splitted_file_names
	 */
	
    public function split( $perc_remains_first_file = 80 ) {
		// We use fgets(). More faster than fgetcsv()
		ini_set("auto_detect_line_endings", true); // Best performance with special chars in fgets()

		$csv_splitted_file_names = [];

		
		$path = '/tmp/'.$this->TimeTokenized.'/';
		
		if (!file_exists($path)) {
			mkdir($path);
		}
		
		$csv_name_parsed = str_replace('.csv', '', basename($this->csv_file_name) ); // Only works with lowercase file names!!!!
		
		$csv_splitted_file_names[0][0] = $path.$csv_name_parsed.'_splitted_'.$perc_remains_first_file.'_1.csv';
		$csv_splitted_file_names[0][1] = $path.$csv_name_parsed.'_splitted_pair_'.$perc_remains_first_file.'_1.csv';
		$csv_splitted_file_names[1][0] = $path.$csv_name_parsed.'_splitted_'.(100-$perc_remains_first_file).'_2.csv';
		$csv_splitted_file_names[1][1] = $path.$csv_name_parsed.'_splitted_pair_'.(100-$perc_remains_first_file).'_2.csv';
		
		unset( $csv_name_parsed );
		unset( $path );
        
        $Spl					= $this->Spl; // Original Data
		$Spl_pair				= $this->Spl_pair; // Original Pair Data

        $SplSplittedFirst		= new SplFileObject( $csv_splitted_file_names[0][0], 'w' );
        $SplPairSplittedFirst	= new SplFileObject( $csv_splitted_file_names[0][1], 'w' );
        $SplSplittedSecond		= new SplFileObject( $csv_splitted_file_names[1][0], 'w' );
        $SplPairSplittedSecond	= new SplFileObject( $csv_splitted_file_names[1][1], 'w' );

		$Spl->rewind();	// Ensure to go at first row
		$Spl_pair->rewind();	// Ensure to go at first row

		$FirstSecondPartRow	= ($perc_remains_first_file * $this->num_rows / 100 );
        
        for($i=0;$i<$this->num_rows; $i++){
			
			try{
				$Str 		= $Spl->fgets();
				$StrPair 	= $Spl_pair->fgets();
			} catch (Exception $e) {
				// With some special chars, fgets function throw an exception. Try then with fgetcsv (more slowly but improve performance)
				
				$Spl->seek($i);
				$Spl_pair->seek($i);
				$Str 		= $Spl->fgetcsv();
				$StrPair 	= $Spl_pair->fgetcsv();
			}

			
			
			if($i<$FirstSecondPartRow){
				print "((";
				var_dump($Str);
				print "))";
				$SplSplittedFirst->fwrite( $Str );
				$SplPairSplittedFirst->fwrite( $StrPair );
			} else {
				$SplSplittedSecond->fwrite( $Str );
				$SplPairSplittedSecond->fwrite( $StrPair );
			}
        }
    
    	// Close Splitteds CSV
        $SplSplittedFirst 		= null;
        $SplSplittedSecond 		= null;
        $SplPairSplittedFirst 	= null;
        $SplPairSplittedSecond 	= null;
		
		unset( $SplSplittedFirst );
		unset( $SplSplittedSecond );
		unset( $SplPairSplittedFirst );
		unset( $SplPairSplittedSecond );
		unset( $i );
		unset( $Str );
		unset( $StrPair );

		$this->csv_splitted_file_names = $csv_splitted_file_names;
        
        return $this->csv_splitted_file_names;
	} // / split()
    
    
    
    /**
	 * Set num_rows class propertie from the list of rows of a file
	 */
    private function set_num_rows( ){
	    $Spl = $this->Spl;
    
        // Try to seek to the highest Int PHP can handle:
        $Spl->seek(PHP_INT_MAX);
        
        // Then actually it will seek to the highest line it could in the file, there is your last line and the last line + 1 is equals to your total lines:
        $this->num_rows = ($Spl->key() + 1);
        
        unset( $Spl );
    }// /set_num_rows()
    
    
    
    /**
	 * Get num_rows
     * 
	 * @return int $num_rows
	 */
    public function get_num_rows( ){
	    return $this->num_rows;
    }// /get_num_rows()
    
    
    
    /**
	 * Get csv_randomized_file_names
     * 
	 * @return array $csv_randomized_file_name
	 */
    public function get_csv_randomized_file_names( ){
		return $this->csv_randomized_file_names;
	 }// /get_csv_randomized_file_names()
    
    
    
    
    
    /**
	 * Get csv_splitted_file_names
     * 
	 * @return string $csv_splitted_file_names
	 */
    public function get_csv_splitted_file_names( ){
		return $this->csv_splitted_file_names;
	 }// /get_csv_splitted_file_names()
    
    
    
    
    
    /**
	 * Get csv_file_name
     * 
	 * @return string $csv_file_name
	 */
    public function get_csv_file_name( ){
		return $this->csv_file_name;
	 }// /get_csv_file_name()
    
    
    
    /**
	 * Get csv_pair_file_name
     * 
	 * @return string $csv_file_name
	 */
    public function get_csv_pair_file_namee( ){
		return $this->csv_pair_file_name;
	 }// /get_csv_pair_file_namee()

 } // /csv_pair_file class
 ?>