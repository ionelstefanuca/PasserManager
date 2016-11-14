<?php
//clasa permite lucrul cu o baza de date oracle

	class Databases
	{
		protected $ref ,$rezultat,$nrRow,$rows;

		//in constructor ne vom conecta la baza de date
		public function __construct ($server, $username, $password)
		{			
			$this->ref=oci_connect($username,$password,$server);
		}
		

		//ne vom deconecta de la baza de date
		public function disconnnectFromDB()
		{
			oci_close($this->ref);
		}

		// vom efectua un select asupra BD
		public function querySelect($sql)
		{
			$this->rezultat=ociparse($this->ref,$sql);
			
			  if(ociexecute($this->rezultat))
				{					
					$this->nrRow = oci_fetch_all($this->rezultat, $this->rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
				}
		}


		//vom apela o procedura dintr-un pachet a BD
	    public function queryBLOCK($param1,$param2)
		{
			$sql = 'BEGIN  pachet.updateParola(:param1,:param2, :message); END;';
			$stmt = oci_parse($this->ref,$sql);	

			oci_bind_by_name($stmt,':param1',$param1,32);
			oci_bind_by_name($stmt,':param2',$param2,64);
			oci_bind_by_name($stmt,':message',$message,2);
			oci_execute($stmt);

			return $message;
		}

		// vom apela o functie pentru a citi date dintr-un csv
		public function uploadCSV($userid,$test4)
		{
					$sql = 'BEGIN  pachet.updateCSV(:userid,:test4); END;';
					$stmt = oci_parse($this->ref,$sql);
					$return ='';


					oci_bind_by_name($stmt,':userid',$userid,32);
					oci_bind_by_name($stmt,':test4',$test4,66);

					if($result=@oci_execute($stmt))
					{
						$return = 'da';
					}
					else
					{
								$e = oci_error($stmt ); 
					            $return = $e['message'];
					}

			return $return;		
		}

		// vom actualiza istoricul logarilor utilizatorilor
		public function uploadIstoricLogin($userid,$browser,$ip,$data)
		{
					$sql = 'BEGIN  pachet.updateIstoricLogin(:userid,:browser,:ip,:data); END;';
					$stmt = oci_parse($this->ref,$sql);
					$return ='';


					oci_bind_by_name($stmt,':userid',$userid,32);
					oci_bind_by_name($stmt,':browser',$browser,500);
					oci_bind_by_name($stmt,':ip',$ip,50);
					oci_bind_by_name($stmt,':data',$data,50);

					if($result=@oci_execute($stmt))
					{
						$return = 'da';
					}
					else
					{
								$e = oci_error($stmt ); 
					            $return = $e['message'];
					}

			return $return;		
		}


		// vom insera noi tuple in BD		
		public function queryInsert ($sql)
		{
			$this->rezultat=ociparse($this->ref,$sql);
			if(ociexecute($this->rezultat))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// va returna nr de randuri ai ultimului select din BD
		public function numRow()
		{
			return $this->nrRow;
		}

		// va returna tuplele sub forma unui vector
		public function rows()
		{
			return $this->rows;
		}

	}

function is_localhost() {
    $whitelist = array( '127.0.0.1', '::1' );
    if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return true;
}

	$ip = is_localhost()?'192.168.1.1':$_SERVER['REMOTE_ADDR'];
	$bazaDeDate = new Databases('localhost/orcl','system','parolaNoua');//conecatarea la baza de date

?>