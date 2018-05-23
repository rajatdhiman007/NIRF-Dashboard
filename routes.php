<?php
Route::get('main', function()
{
	
// 	return View::make('/nirf_project/frontend/front_end/main');
// });

// Route::get('main', function()
// {
	$link = mysqli_connect('localhost', 'root', '');

$a="SHOW DATABASES";
$res= $link->query($a);
$i=0;
while ($row = mysqli_fetch_object($res)) {
    $abc=$row->Database."\n";
    $college_names[$i]=explode(': ', $abc);
    
    $i = $i + 1;
}


	 // dd($college_names);		
    	
    
    return View::make('/nirf_project/frontend/front_end/main')->with('college_names',$college_names);
	

});


Route::get('college_paper_details', function()
{
$link = mysqli_connect('localhost', 'root', '');

$a="SHOW DATABASES";
$res= $link->query($a);
$i=0;
while ($row = mysqli_fetch_object($res)) {
	    $abc=$row->Database;
	    $college_names[$i]=explode(': ', $abc);
	    // dd($college_names[$i][0]);
	 	if (($college_names[$i][0]==="information_schema") || ($college_names[$i][0]==="nirf") || ($college_names[$i][0]==="button")||($college_names[$i][0]==="mysql")|| ($college_names[$i][0]==="sys")  ) {
	 		continue;
	 	}
	 
	    $i = $i + 1;
	}


	 // dd($college_names);		
    	
    
    return View::make('/nirf_project/frontend/front_end/college_papers')->with('college_names',$college_names);
});


Route::get('college_paper_selected', function()
{
	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res)) {
	    $abc=$row->Database."\n";
	    $college_names[$i]=explode(': ', $abc);
	    $i = $i + 1;
}



	$selected_college= Input::get('selected_college');
	// print_r($selected_college);
	// // if($selected_college=="jiit")
	// // {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $selected_college;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_publication_data1="SELECT * from publication_details WHERE Source_of_Data='Web of Science'";
		$q1=$conn->query($get_publication_data1);
		if ($q1->num_rows > 0) {
	    while($row = $q1->fetch_assoc()) {
	        $a1 =$row["Publications"];
	    }}
	    $get_publication_data2="SELECT * from publication_details WHERE Source_of_Data='Scopus'";
		$q2=$conn->query($get_publication_data2);
		if ($q2->num_rows > 0) {
	    while($row = $q2->fetch_assoc()) {
	        $a2 =$row["Publications"];
	    }}
	    $get_publication_data3="SELECT * from publication_details WHERE Source_of_Data='Web of Science'";
		$q3=$conn->query($get_publication_data3);
		if ($q3->num_rows > 0) {
	    while($row = $q3->fetch_assoc()) {
	        $a3 =$row["Citations"];
	    }}
	    // dd($a3);
	    $get_publication_data4="SELECT * from publication_details WHERE Source_of_Data='Scopus'";
		$q4=$conn->query($get_publication_data4);
		if ($q4->num_rows > 0) {
	    while($row = $q4->fetch_assoc()) {
	        $a4 =$row["Citations"];
	    }}
	    // dd($a4);
	    // dd($a1);
	    // echo $a1;
		

		return View::make('/nirf_project/frontend/front_end/publication_details')->with('college_names',$college_names)->with('selected_college',$selected_college)->with('a2',$a2)->with('a1',$a1)->with('a3',$a3)->with('a4',$a4);
});

Route::get('college', function()
{
	// $ratio=Input::get('ratio');
	$college_name=Input::get('college_name');
	// $total_faculty=Input::get('total_faculty');
	// $total_student=Input::get('total_student');

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $college_name;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_faculty_data="SELECT SUM(Total_no_of_Faculty_members) as aggregate from faculty_details";
		$q1=$conn->query($get_faculty_data);
		if ($q1->num_rows > 0) {
	    while($row = $q1->fetch_assoc()) {
	        $a1 =$row["aggregate"];
	    }}

	    $get_student_data="SELECT SUM(Total_no_of_students_studying_in_all_years_of_all_programs) as aggregate from student_details";
		$q2=$conn->query($get_student_data);
				if ($q2->num_rows > 0) {
	    while($row = $q2->fetch_assoc()) {
	        $a2= $row["aggregate"];
	    }}
		$ratio= $a2/$a1;
		$data = new \stdClass();
		$data->ratio=$ratio;
		$data->college_name=$college_name;
		$data->total_faculty=(int)$a1;
		$data->total_student=(int)$a2;

	// $q=[$ratio,$college_name,$a1,$a2];
	$q=json_encode($data);
$myfile = fopen("testfile.json", "w") or die("Unable to open file!");
fwrite($myfile, $q);	
fclose($myfile);



		
		echo $q;
		// dd($q);
	// dd();
});

Route::get('compare_colleges', function()
{
	$faculty_limit=Input::get('faculty_limit');
	$student_limit=Input::get('student_limit');
	$cpd_limit=Input::get('cpd_limit');
	// dd($cpd_limit);
	if($faculty_limit && $student_limit==0 )
	{


	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res) ) {
	    $abc=$row->Database;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=10;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    // dd($college_names[$i][0]);
	 	if (($college_names[$i]->label==="information_schema") || ($college_names[$i]->label==="nirf") || ($college_names[$i]->label==="button")||($college_names[$i]->label==="mysql")|| ($college_names[$i]->label==="sys")||($college_names[$i]->label==="performance_schema") ) {
	 		continue;
	 	}
	 	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $college_names[$i]->label;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_faculty=" SELECT * from faculty_details";
		$q3=$conn->query($get_faculty) or die($conn->error);
		// dd($q3);
				// if ($q3->num_rows > 0) {
	    while($def = $q3->fetch_assoc()) {
	        $f1= $def["No_of_Faculty_members_with_PhD_qualification"];
	        $f2= $def["Total_no_of_Faculty_members"];
	        $f3= $def["No_of_Women_Faculty_members"];
	    	}
	    // $college_names[$i]->y=$f2;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=(int)$f2;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    if($college_names[$i]->y <= $faculty_limit)
	    {
// 	 		$abcd=array_shift($college_names[$i]);   
// dd($abcd);
	    	continue;
	    }
	    $i = $i + 1;
	    	// break;
	}
}
	// dd(json_encode($college_names));
		if($student_limit && $faculty_limit==0 )
		{
			// dd( "abcdefg");

	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res) ) {
	    $abc=$row->Database;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=10;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    // dd($college_names[$i][0]);
	 	if (($college_names[$i]->label==="information_schema") || ($college_names[$i]->label==="nirf") || ($college_names[$i]->label==="button")||($college_names[$i]->label==="mysql")|| ($college_names[$i]->label==="sys")||($college_names[$i]->label==="performance_schema") ) {
	 		continue;
	 	}
	 	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $college_names[$i]->label;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_student_data="SELECT SUM(Total_no_of_students_studying_in_all_years_of_all_programs) as aggregate from student_details";
		$q2=$conn->query($get_student_data);
				// if ($q2->num_rows > 0) {
	    while($row = $q2->fetch_assoc()) {
	        $a2= $row["aggregate"];
	    }
	    // $college_names[$i]->y=$f2;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=(int)$a2;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    if($college_names[$i]->y <= $student_limit)
	    {
// 	 		$abcd=array_shift($college_names[$i]);   
// dd($abcd);
	    	continue;
	    }
	    $i = $i + 1;
	    	// break;
	}
}
		if($cpd_limit!="choose" && $faculty_limit==0 && $student_limit==0)
	{
		// dd("abc");


	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res) ) {
	    $abc=$row->Database;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=10;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    // dd($college_names[$i][0]);
	 	if (($college_names[$i]->label==="information_schema") || ($college_names[$i]->label==="nirf") || ($college_names[$i]->label==="button")||($college_names[$i]->label==="mysql")|| ($college_names[$i]->label==="sys")||($college_names[$i]->label==="performance_schema") ) {
	 		continue;
	 	}
	 	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $college_names[$i]->label;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_faculty=" SELECT * from consultancy_project_details";
		$q3=$conn->query($get_faculty) or die($conn->error);
		// dd($q3);
				// if ($q3->num_rows > 0) {
	    while($def = $q3->fetch_assoc()) {
	        
	        $f2= $def["Amount"];
	        
	    	}
	    // $college_names[$i]->y=$f2;
	    $college_names[$i] = new stdClass();
	    $college_names[$i]->y=(int)$f2;
	    $college_names[$i]->label=explode(': ', $abc)[0];
	    if($college_names[$i]->y == $cpd_limit)
	    {
// 	 		$abcd=array_shift($college_names[$i]);   
// dd($abcd);
	    	continue;
	    }
	    $i = $i + 1;
	    	// break;
	}
	}
	
		return View::make('/nirf_project/frontend/front_end/compare')->with('college_names',json_encode($college_names));
});
Route::get('compare_limit', function()
{
	return View::make('/nirf_project/frontend/front_end/compare_limit');
	// return redirect()->route('compare_colleges');
	// Redirect::route('compare_colleges');
});
Route::get('login', function()
{

	$flag_update=DB::table('login_details')->update(['flag' => 0]);
	Session::forget('flag');
	Session::flush();
	Session::regenerate();
	// return View::make('/JPEG_project/login');
	return View::make('/nirf_project/frontend/front_end/login');
});



Route::post('login_control_nirf', function()
{
	$username=Input::get('username');
	$password=Input::get('password');

	$check = DB::table('login_details')->where('username', '=', $username)->where('password', '=', $password)->get();

	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res)) {
	    $abc=$row->Database;
	    $college_names[$i]=explode(': ', $abc);
	    // dd($college_names[$i][0]);
	 	if (($college_names[$i][0]==="information_schema") || ($college_names[$i][0]==="nirf") || ($college_names[$i][0]==="button")||($college_names[$i][0]==="mysql")|| ($college_names[$i][0]==="sys")  ) {
	 		continue;
	 	}
	 
	    $i = $i + 1;
	}
	
// $array = array_diff($college_names, ["information_schema", "nirf"]);
// 	while ($row = mysqli_fetch_object($res)) {
// // $arr = array_diff($college_names[$i], array("information_schema", "nirf"));
// if ($college_names[$i]=="information_schema") {
// 	 		continue;
// 	 	}
// 	 	$i = $i + 1;
// dd($arr);
// }
        if(!$check)
        {
            
			$message = "Wrong username or password!!";
echo "<script type='text/javascript'>alert('$message');</script>";
			return View::make('/nirf_project/frontend/front_end/login');

	       
        }
        else
        {
        	 $flag_update=DB::table('login_details')->where('username', $username)->update(['flag' => 1]);
        	$name= DB::table('login_details')->select('name')->get();
// dd($name->name);
        	// echo $name[0]->name;
        	
        	return View::make('/nirf_project/frontend/front_end/main')->with('name',$name)->with('college_names',$college_names);
        }

	
});


Route::get('college_selected', function()
{
	$link = mysqli_connect('localhost', 'root', '');

	$a="SHOW DATABASES";
	$res= $link->query($a);
	$i=0;
	while ($row = mysqli_fetch_object($res)) {
	    $abc=$row->Database."\n";
	    $college_names[$i]=explode(': ', $abc);
	    $i = $i + 1;
}



	$selected_college= Input::get('selected_college');
	// print_r($selected_college);
	// // if($selected_college=="jiit")
	// // {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $selected_college;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$get_faculty_data="SELECT SUM(Total_no_of_Faculty_members) as aggregate from faculty_details";
		$q1=$conn->query($get_faculty_data);
		if ($q1->num_rows > 0) {
	    while($row = $q1->fetch_assoc()) {
	        $a1 =$row["aggregate"];
	    }}
	    // echo $a1;
		$get_student_data="SELECT SUM(Total_no_of_students_studying_in_all_years_of_all_programs) as aggregate from student_details";
		$q2=$conn->query($get_student_data);
				if ($q2->num_rows > 0) {
	    while($row = $q2->fetch_assoc()) {
	        $a2= $row["aggregate"];
	    }}
		$ratio= $a2/$a1;
		// dd(json_encode($ratio));
///////////////////
		$get_faculty=" SELECT * from faculty_details";
		$q3=$conn->query($get_faculty);
				if ($q3->num_rows > 0) {
	    while($row = $q3->fetch_assoc()) {
	        $f1= $row["No_of_Faculty_members_with_PhD_qualification"];
	        $f2= $row["Total_no_of_Faculty_members"];
	        $f3= $row["No_of_Women_Faculty_members"];
	    }}

	    $get_student=" SELECT SUM(No_of_Male_students_studying_in_all_years_of_all_programs) as abc,SUM(No_of_Female_students_studying_in_all_year_of_all_programs) as def,SUM(Total_no_of_students_studying_in_all_years_of_all_programs) as ghi from student_details";
		$q4=$conn->query($get_student);
				if ($q4->num_rows > 0) {
	    while($row = $q4->fetch_assoc()) {
	        $s1= $row["abc"];
	        $s2= $row["def"];
	        $s3= $row["ghi"];
	    }}
//////////////////


		return View::make('/nirf_project/frontend/front_end/mdetails')->with('college_names',$college_names)->with('selected_college',$selected_college)->with('ratio',$ratio)->with('a2',$a2)->with('a1',$a1)->with('f1',$f1)->with('f2',$f2)->with('f3',$f3)->with('s1',$s1)->with('s2',$s2)->with('s3',$s3);
});

/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('nirfaa', function()
{
libxml_use_internal_errors(true);
$doc = new \DOMDocument();
$doc->loadHTMLFile('https://www.nirfindia.org/EngineeringRanking.html');
$xpath = new \DOMXPath($doc);
$elements = $xpath->query("//table[@id='tbl_overall']/tbody/child::tr/td[2]/div[1]/a[3]/@href");
$columns = array(3,11,5,5,4,4,3,3,2,2,3,3);

	
foreach ($elements as $element) {
	#file_put_contents("temp.pdf", fopen($element->nodeValue, 'r'));
	#echo $element->nodeValue."\n";
	file_put_contents("/temp.pdf", fopen($element->nodeValue, 'r'));
	$a = shell_exec("PATH=C:/New Folder (2)/poppler-0.51/bin; && pdftohtml -noframes -nomerge -s C:/temp.pdf C:/temp.html");
	$html = file_get_contents("/temp.html");
	$doc2 = new \DOMDocument();
	$doc2->loadHTML($html);
	$xpath2 = new \DOMXPath($doc2);
	$counter = 0;
	$local_counter = 0;
	$tables = array();
	$table = array();
	$names=array();
	
	$elements3 = $xpath2->query("//p[@class='ft11']");
	$elements2 = $xpath2->query("//p[  starts-with(@class, 'ft') and substring(@class, string-length(@class) - string-length('3') +1)='3']");

	$gotName=explode(': ', $elements3[sizeof($elements3)]->nodeValue)[1];
	$gotName1=preg_replace("/[^a-zA-Z]/", " ", $gotName);
	$gotName2=str_replace(' ', '_', $gotName1);
	$univName=substr($gotName2, 0,50);
	print_r($univName);

	foreach ($elements2 as $i => $element2){

		array_push($table, $element2->nodeValue);
		#echo $element2->nodeValue."    ";
		$local_counter = $local_counter+1;
		$next = $xpath2->query("following-sibling::p[1]",$element2)[0];
		if ((!is_null($elements2[$i+1]))){
			
			if ($counter==9 && $local_counter < 6){
					continue;
				}

			if(!is_null($next)){
				if (!$elements2[$i+1]->isSameNode($next)){
		 			#echo "<br>";
		 			$local_counter = 0;
		 			array_push($tables, array_chunk($table, $columns[$counter]));
		 			$table = array();
					$counter = $counter+1;
				}
			}
			else{
				#echo "<br>";
		 		array_push($tables, array_chunk($table, $columns[$counter]));
		 		$table = array();
		 		$local_counter = 0;
				$counter = $counter+1;
			}
	    }

	    else{
				#echo "<br>";
		 		array_push($tables, array_chunk($table, $columns[$counter]));
		 		$table = array();
		 		$local_counter = 0;
				$counter = $counter+1;
			}
		}

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname ="nirf"; 
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$databaseName = "CREATE DATABASE IF NOT EXISTS $univName";
		$conn->exec($databaseName);
		$dbname ="$univName";
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$name=DB::Connection()->getDatabasename();
		print_r($name);

		//t1
		$table1 = "CREATE TABLE IF NOT EXISTS faculty_details (
				No_of_Faculty_members_with_PhD_qualification INT,
				Total_no_of_Faculty_members INT,
				No_of_Women_Faculty_members INT
		)";
		$conn->exec($table1);

		foreach ($tables[0] as $row) {
			$ins_t1= "INSERT INTO faculty_details(
						No_of_Faculty_members_with_PhD_qualification,
						Total_no_of_Faculty_members,No_of_Women_Faculty_members)
				VALUES($row[0],$row[1],$row[2])";
			$conn->exec($ins_t1);
		}
//t2	
		$table2 = "CREATE TABLE IF NOT EXISTS Student_Details (
			    Academic_Year VARCHAR(300), 
			    Program_Level VARCHAR(300),
			    ApproveIntake_of_all_years_of_duration INT,
			    No_of_Male_students_studying_in_all_years_of_all_programs INT,
			    No_of_Female_students_studying_in_all_year_of_all_programs INT,
			    Total_no_of_students_studying_in_all_years_of_all_programs INT,
			    No_of_students_from_Within_the_State INT,
			    No_of_students_from_Outside_State INT,
			    No_of_students_from_Outside_Country INT,
			    No_of_students_from_Economically_Backward_Class INT
			    -- No_of_students_from_Socially_Challenged_Category INT
			    )";
$conn->exec($table2);

		foreach ($tables[1] as $row) {
			$ins_t2= "INSERT INTO Student_Details (
						Academic_Year , 
					    Program_Level ,
					    ApproveIntake_of_all_years_of_duration ,
					    No_of_Male_students_studying_in_all_years_of_all_programs ,
					    No_of_Female_students_studying_in_all_year_of_all_programs ,
					    Total_no_of_students_studying_in_all_years_of_all_programs ,
					    No_of_students_from_Within_the_State ,
					    No_of_students_from_Outside_State ,
					    No_of_students_from_Outside_Country ,
					    No_of_students_from_Economically_Backward_Class 
					    -- No_of_students_from_Socially_Challenged_Category 
						)
				VALUES('$row[0]','$row[1]',$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9])";
			$conn->exec($ins_t2);
		}
//t3
		$table3 = "CREATE TABLE IF NOT EXISTS Placement_and_Higher_Studies (
				Academic_Year VARCHAR(300),
				Program VARCHAR(300),
				No_of_students_placed_through_campus_placement INT,
				NO_of_students_selected_for_higher_studies INT,
				Median_salary_of_placed_graduates INT

					)";	
$conn->exec($table3);
			foreach ($tables[2] as $row) {
			$ins_t3= "INSERT INTO Placement_and_Higher_Studies(
						Academic_Year ,
						Program ,
						No_of_students_placed_through_campus_placement ,
						NO_of_students_selected_for_higher_studies ,
						Median_salary_of_placed_graduates 
						)
				VALUES('$row[0]','$row[1]',$row[2],$row[3],$row[4])";
			$conn->exec($ins_t3);
		}
//t4		
		$table4 = "CREATE TABLE IF NOT EXISTS University_Exam_Details (
				Academic_Year VARCHAR(300), 
			    Program VARCHAR(300),
			    No_of_students_admitted_in_the_first_year INT,
			    No_of_students_admitted_through_lateral_entry INT,
			    No_of_students_graduating_inminimum_stipulated_time INT

		)";
$conn->exec($table4);

			foreach ($tables[3] as $row) {
			$ins_t4= "INSERT INTO University_Exam_Details(
						Academic_Year , 
					    Program ,
					    No_of_students_admitted_in_the_first_year ,
					    No_of_students_admitted_through_lateral_entry ,
					    No_of_students_graduating_inminimum_stipulated_time)
				VALUES('$row[0]','$row[1]',$row[2],$row[3],$row[4])";
			$conn->exec($ins_t4);
		}

//t5
		$table5 = "CREATE TABLE IF NOT EXISTS Financial_Resources_and_its_Utilization (
				Financial_Year VARCHAR(300),
				Annual_Capital_Expenditure DOUBLE,
				Annual_Operational_Expenditure DOUBLE,
				Total_Annual_Expenditure DOUBLE
		)";
$conn->exec($table5);
		foreach ($tables[4] as $row) {
			$ins_t5= "INSERT INTO Financial_Resources_and_its_Utilization(
						Financial_Year ,
						Annual_Capital_Expenditure ,
						Annual_Operational_Expenditure ,
						Total_Annual_Expenditure )
				VALUES('$row[0]',$row[1],$row[2],$row[3])";
			$conn->exec($ins_t5);
		}
//t6
		$table6 = "CREATE TABLE IF NOT EXISTS Patent_Details (
			No_of_Patents_Granted INT,
			No_of_Patents_Published INT,
			Earnings_from_Patents INT
		)";
$conn->exec($table6);
		foreach ($tables[7] as $row) {
			$ins_t6= "INSERT INTO Patent_Details(
						No_of_Patents_Granted ,
						No_of_Patents_Published ,
						Earnings_from_Patents 
						 )
				VALUES($row[0],$row[1],$row[2])";
			$conn->exec($ins_t6);
		}

//t7
		$table7 = "CREATE TABLE IF NOT EXISTS Useless_table (
			Source_of_Data VARCHAR(300),
			Publications INT,
			Citations INT
		)";
$conn->exec($table7);
		foreach ($tables[6] as $row) {
			$ins_t7= "INSERT INTO Useless_table(
						Source_of_Data ,
			Publications ,
			Citations 
						 )
				VALUES('$row[0]',$row[1],$row[2])";
			$conn->exec($ins_t7);
		}

//t8
		$table8 = "CREATE TABLE IF NOT EXISTS Sponsored_Research_Project_Details (
			Financial_Year VARCHAR(300),
			Amount DOUBLE
		)";
$conn->exec($table8);
		foreach ($tables[8] as $row) {
			$ins_t8= "INSERT INTO Sponsored_Research_Project_Details(
						Financial_Year,
						Amount 
						 )
				VALUES('$row[0]',$row[1])";
			$conn->exec($ins_t8);
		}

		
//t9
		$table9 = "CREATE TABLE IF NOT EXISTS Consultancy_Project_Details (
			Financial_Year VARCHAR(300),
			Amount DOUBLE
		)";
$conn->exec($table9);
		foreach ($tables[9] as $row) {
			$ins_t9= "INSERT INTO Consultancy_Project_Details(
						Financial_Year,
						Amount 
						 )
				VALUES('$row[0]',$row[1])";
			$conn->exec($ins_t9);
		}
//t10
		$table10 = "CREATE TABLE IF NOT EXISTS Perception_Details (
				Peer_Perception INT,
				Employer_Perception INT,
				Public_Perception INT

		)";
$conn->exec($table10);
		foreach ($tables[11] as $row) {
			$ins_t10= "INSERT INTO Perception_Details(
						Peer_Perception ,
				Employer_Perception ,
				Public_Perception 
						 )
				VALUES($row[0],$row[1],$row[2])";
			$conn->exec($ins_t10);
		}
//t11
$table11 = "CREATE TABLE IF NOT EXISTS Publication_Details (
			Source_of_Data VARCHAR(300),
			Publications INT,
			Citations INT,
			Top_25_Highly_Cited_Papers INT
		)";
$conn->exec($table11);
		foreach ($tables[5] as $row) {
			$ins_t11= "INSERT INTO Publication_Details(
						Source_of_Data ,
						Publications ,
						Citations ,
						Top_25_Highly_Cited_Papers 
						 )
				VALUES('$row[0]',$row[1],$row[2],$row[3])";
			$conn->exec($ins_t11);
		}


	// dd($tables);


}

libxml_clear_errors();
});

Route::get('/', function()
{
	$name=DB::Connection()->getDatabasename();
	return "Connected to".$name;
});

////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////


Route::get('loginjpeg', function()
{
	$flag_update=DB::table('user_data')->update(['flag' => 0]);
	Session::forget('flag');
	Session::flush();
	Session::regenerate();
	return View::make('/JPEG_project/login');
});

Route::post('login_control', function()
{
	$username=Input::get('username');
	$password=Input::get('password');

	$check = DB::table('user_data')->where('username', '=', $username)->where('password', '=', $password)->get();


        if(!$check)
        {
            
			$message = "Wrong username or password!!";
echo "<script type='text/javascript'>alert('$message');</script>";
			return View::make('/JPEG_project/login');

	       
        }
        else
        {
        	 $flag_update=DB::table('user_data')->where('username', $username)->update(['flag' => 1]);
        	$user_details = DB::table('user_data')->select('fullname', 'emailid','contactno')->get();
        	// $fnames= DB::table('user_data')->get();
        	// $unames= DB::table('user_data')->select('username')->get();
        	// Session::put('flag', 1);
        	// $fullname=DB::table('user_data')->select('fullname')->where('flag', 1)->get();
        	$fullname=Input::get('fullname');
			$contactno=Input::get('contact');
			$emailid=Input::get('emailid');
        	// return View::make('/JPEG_project/main_screen');
        	// print_r($unames);

			$fnames = DB::table('user_data')
            ->join('user_pictures', 'user_data.username', '=', 'user_pictures.username')
            ->select('user_data.fullname','user_data.username', 'user_pictures.filename')
            ->get();



        	
        	return View::make('/JPEG_project/main_screen')->with('username',$username)->with('fullname',$fullname)->with('contactno',$contactno)->with('emailid',$emailid)->with('fnames',$fnames);
        }

	
});

Route::get('main_screen_home', function()
{
	$username=Input::get('username');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        	if($check)
        	{
        	//$fullname = $check[0]->fullname;
        	//echo $fullname;
        	$user_details = DB::table('user_data')->select('fullname', 'emailid','contactno')->get();
			//$user_details = DB::table('user_data')->select('fullname', 'emailid','contactno')->get();
			$fullname=Input::get('fullname');
			$contactno=Input::get('contact');
			$emailid=Input::get('emailid');
			$fnames = DB::table('user_data')
            ->join('user_pictures', 'user_data.username', '=', 'user_pictures.username')
            ->select('user_data.fullname','user_data.username', 'user_pictures.filename')
            ->get();
            
		
		// return Redirect::route('main_screen');
            return View::make('/JPEG_project/main_screen')->with('username',$username)->with('fullname',$fullname)->with('contactno',$contactno)->with('emailid',$emailid)->with('fnames',$fnames);
	
}
});

Route::post('main_screen_control', function()
{
	$username=Input::get('username');
	$password=Input::get('password');
	$fullname=Input::get('fullname');
	$contactno=Input::get('contact');
	$emailid=Input::get('emailid');
	$interest=Input::get('interest');

        	$dup = DB::table('user_data')->where('username', '=', $username)->get();
        if(count($dup) >0)
        {
            
			$message = "username Already Used.";
echo "<script type='text/javascript'>alert('$message');</script>";
			return View::make('/JPEG_project/signup');

	       
        }
        else
        {
        	DB::table('user_data')->insert(array('username' => $username , 'password' => $password, 'fullname' => $fullname,'contactno' => $contactno,'emailid' => $emailid,'interest' => $interest ));

        	$fnames = DB::table('user_data')
            ->join('user_pictures', 'user_data.username', '=', 'user_pictures.username')
            ->select('user_data.fullname','user_data.username', 'user_pictures.filename')
            ->get();
            

        	return View::make('/JPEG_project/main_screen')->with('username',$username)->with('fullname',$fullname)->with('contactno',$contactno)->with('emailid',$emailid)->with('fnames',$fnames);
        }
	
	
});


Route::get('signup', function()
{
	return View::make('/JPEG_project/signup');
});



Route::get('locatestore', function()
{
	$username=Input::get('username');
	
	return View::make('/JPEG_project/locatestore')->with('username', $username);
});

Route::get('profile', function()
{
	$username=Input::get('username');
	$fullname=Input::get('fullname');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        if($check)
        {
        	//$fullname = $check[0]->fullname;
        	//echo $fullname;
        	
			//$user_details = DB::table('user_data')->select('fullname', 'emailid','contactno')->get();
			$fullname=$check[0]->fullname;
			$contactno=$check[0]->contactno;
			$emailid=$check[0]->emailid;
			$interest=$check[0]->interest;
			
			$directory='images/profile_pictures/';
			$files = File::allFiles($directory);
			foreach ($files as $file)
			{
				$file = substr($file,25);
				if(starts_with($file, $username) == 1)
					{
					 $check = DB::table('user_pictures')->where('username', '=', $username)->where('filename', '=', $file)->get();
			        if(!$check)
			        {
						DB::table('user_pictures')->insert(array('username' => $username ,'fullname' => $fullname,'filename' => $file));
					}

					}//echo $value;
			}

			$pictures = DB::table('user_pictures')->select('filename')->where('username', '=', $username)->get();
			
			// $filename=$pictures->filename;
			// foreach ($pictures as $picture) {
			// 	echo $picture['filename'];
			// }
			// $image=$username.$pictures;
// ****************************************************************************
		// $directory='images/';
		// 	$users_dp = File::allFiles($directory);
		// 	foreach ($users_dp as $user_dp)
		// 	{
		// 		$user_dp = substr($user_dp,8);
		// 		if(starts_with($user_dp, $username) == 1)
		// 			{
		// 			 $check = DB::table('user_pictures')->where('username', '=', $username)->where('user_dp', '=', $user_dp)->get();
		// 	        if(!$check)
		// 	        {
		// 				DB::table('user_pictures')->insert(array('username' => $username ,'fullname' => $fullname,'filename' => $file));
		// 			}

		// 			}//echo $value;
		// 	}	
		// 	$user_dp = DB::table('user_pictures')->select('user_dp')->where('username', '=', $username)->get();
// *********************************************************************************
		
			return View::make('/JPEG_project/profile')->with('username', $username)->with('emailid', $emailid)->with('fullname', $fullname)->with('pictures', $pictures)->with('interest', $interest);	
		}
		
});

Route::post('edit_profile', function()
{
	$username=Input::get('username');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        if($check)
        {
		$fullname=$check[0]->fullname;
			$contactno=$check[0]->contactno;
			$emailid=$check[0]->emailid;
			
	$info = pathinfo($_FILES['pic']['name']);
	$name =  $_FILES['pic']['name'];
	$newname = $name; 

	$target = 'images/profile_pictures/'.$username.$newname;
	move_uploaded_file( $_FILES['pic']['tmp_name'], $target);	
	// ****************************file uploaded**********************************

	$directory='images/profile_pictures/';
			$files = File::allFiles($directory);
			foreach ($files as $file)
			{
				$file = substr($file,25);
				if(starts_with($file, $username) == 1)
					{
					 $check = DB::table('user_pictures')->where('username', '=', $username)->where('filename', '=', $file)->get();
			        if(!$check)
			        {
						DB::table('user_pictures')->insert(array('username' => $username ,'fullname' => $fullname,'filename' => $file));
					}

					}//echo $value;
			}

			$pictures = DB::table('user_pictures')->select('filename')->where('username', '=', $username)->get();

		return View::make('/JPEG_project/profile')->with('username', $username)->with('fullname', $fullname)->with('pictures', $pictures);
		
	

	}
	
});


Route::post('store_location_data', function()
{
	$username=Input::get('username');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        if($check)
        {
		$fullname=$check[0]->fullname;
			$contactno=$check[0]->contactno;
			$emailid=$check[0]->emailid;
		




	$info = pathinfo($_FILES['pic']['name']);
	$name =  $_FILES['pic']['name'];
	$newname = $name; 

	$target = 'images/'.$newname;
	move_uploaded_file( $_FILES['pic']['tmp_name'], $target);
	return View::make('/JPEG_project/locatestore')->with('username', $username)->with('fullname', $fullname)->with('pictures', $pictures);
}
});

Route::get('search_route', function()
{
	// use Goutte\Client;
	$username=Input::get('username');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        if($check)
        {
		$fullname=$check[0]->fullname;
		$contactno=$check[0]->contactno;
		$emailid=$check[0]->emailid;
		// $client = new Client();
		return View::make('/JPEG_project/search')->with('username', $username)->with('fullname', $fullname);
}
});

///////////////////////
//major I//////////////
//////////////////////
//////////////////////

Route::get('find_freelancer', function()
{
	$username=Input::get('username');
	$check = DB::table('user_data')->where('username', '=', $username)->get();


        if($check)
        {
		$fullname=$check[0]->fullname;
			$contactno=$check[0]->contactno;
			$emailid=$check[0]->emailid;
			$pictures = DB::table('user_pictures')->select('filename')->where('username', '=', $username)->get();

		return View::make('/JPEG_project/find_freelancers')->with('username', $username)->with('fullname', $fullname)->with('pictures', $pictures);
	}
	
});

use Symfony\Component\Process\Process;

Route::get('reviews', function()
{

	$review=Input::get('review');
	$username=Input::get('username');
	$user_reviewed= Input::get('user_reviewed');
	   
	$input_review = addslashes($review);
	$process = new Process("cd c:/python36 && python Reviews-Classification-CNN/eval.py --eval_data \"".$input_review."\"");
	$process->run();
	
	DB::table('reviews')->insert(array('username' => $user_reviewed, 'reviews' => $review,'review_type' => $process->getOutput() ));
	// echo $process->getOutput();
	//echo "data inserted!";
	$process->clearOutput();
	$review_count= DB::table('reviews')->where('review_type','=',"1")->where('username','=',$user_reviewed)->count();
	// var_dump($review_count);
	// return Redirect('free_search')->with('review_count',$review_count);
	return Redirect::back();
});


Route::get('free_search', function()
{
	$username=Input::get('username');
	$search=Input::get('search');
	$check = DB::table('user_data')->where('username', '=', $username)->get();
	$freelancer_details =DB::table('user_data')->where('interest', '=', $search)->get();
	$free_fullname=array();
        if($check)
        {
			$fullname=$check[0]->fullname;
			$contactno=$check[0]->contactno;
			$emailid=$check[0]->emailid;
			$interest=$check[0]->interest;
			$pictures = DB::table('user_pictures')->select('filename')->where('username', '=', $username)->get();
			
			if ($freelancer_details) 
			{
				// foreach ($freelancer_details as $freelancerdetails) {
					$free_uid=DB::table('user_data')->select('user_id')->get();
					$user_uid=DB::table('user_pictures')->select('user_id')->get();


					// $review_count= DB::table('reviews')->where('review_type','=',"1")->where('username','=',$freelancer_details->username)->count();
				
				return View::make('/JPEG_project/searched_freelancers')->with('username', $username)->with('fullname', $fullname)->with('pictures', $pictures)->with('freelancer_details', $freelancer_details)->with('search', $search);
				

				// with('free_fullname', $free_fullname)->with('free_contactno', $free_contactno)->with('free_emailid', $free_emailid)->with('free_interest', $free_interest)->;
				// }
			}
			else
			{

				$message = "NO USER FOUND IN THIS CATEGORY!!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				return View::make('/JPEG_project/find_freelancers')->with('username', $username)->with('fullname', $fullname)->with('pictures', $pictures);
			}
		}
});
//////////////////////////////////////////////////
///////////majorI closes here////////////////////
/////////////////////////////////////////////////





Route::post('search_algo', function()
{
	// use Goutte\Client;
	$search_username=Input::get('search_username');
	$name=DB::table('user_data')->where('flag', '=', 1)->get();
	$username= $name[0]->username;
	$check = DB::table('user_data')->where('username', '=', $search_username)->get();


        if($check)
        {
		$fullname=$check[0]->fullname;
		$contactno=$check[0]->contactno;
		$emailid=$check[0]->emailid;
		// $client = new Client();
		$directory='images/profile_pictures/';
			$files = File::allFiles($directory);
			foreach ($files as $file)
			{
				$file = substr($file,25);
				if(starts_with($file, $search_username) == 1)
					{
					 $check = DB::table('user_pictures')->where('username', '=', $search_username)->where('filename', '=', $file)->get();
			        if(!$check)
			        {
						DB::table('user_pictures')->insert(array('username' => $search_username ,'fullname' => $fullname,'filename' => $file));
					}

					}
			}

			$pictures = DB::table('user_pictures')->select('filename')->where('username', '=', $search_username)->get();

		return View::make('/JPEG_project/search')->with('username', $username)->with('search_username', $search_username)->with('fullname', $fullname)->with('pictures', $pictures);
}
});


// /////////////////////////////////////////Project2////////////////////////////////////Project2//////////////////
// ////////////////////////Project2///////////////////Project2///////////////////Project2////////////////////////
// /////////////////////////////////Project2//////////////////////Project2//////////////////////////////////////


// Route::get('locatehospital',function()
// {
	

// return View::make('locatehospital');
// });

// Route::post('signupcontrol',function()
// {
	
// $l1=Input::get('name');
// $l2=Input::get('mobile');
// $l4=Input::get('email');
// $l3=Input::get('bloodgroup');
// DB::table('articlehom')->insert(array('nam' => $l1 ,'mobile' => $l2,'bloodgroup' => $l3,'email' => $l4));
// return View::make('/healthcheckup')->with('nam', $l1)->with('mobile', $l2)->with('bloodgroup', $l3)->with('email', $l4);
// });


// Route::post('textmessage',function()
// {
// 	$smsmessage=Input::get('smsmessage');
// 	$bloodgroups=Input::get('bloodgroups');
// 	$i=0;
// 	DB::table('smsmessage')->insert(array('message' => $smsmessage ,'bloodgroup' => $bloodgroups));

// 	$check = DB::table('articlehom')->where('bloodgroup', '=', $bloodgroups)->get();
//         if($check)
//         {
        	
//         	$mob = DB::table('articlehom')->select('mobile')->where('bloodgroup','=',$bloodgroups)->get();
//         	$mobile = array();
// 			 for ($i=0; $i < count($mob); $i++) { 
// 				array_push(	$mobile, $mob[$i]->mobile);
// 			 }
				
			
// 			 return View::make('message')->with('smsmessage',$smsmessage)->with('mobile',$mobile);
						
// 		}
// 		else
// 		{
			
// 			return View::make('/healthcheckup');		
				
// 		}

// });

// Route::get('healthcheckup',function()
// {
// 	$l1=Input::get('name');
// $l2=Input::get('mobile');
// $l4=Input::get('email');
// $l3=Input::get('bloodgroup');
// return View::make('healthcheckup');
// });

// Route::get('healthtopics',function()
// {
// return View::make('health');
// });

// Route::get('/', function()
// {
	
 
// $ngos=DB::table('ngosign')->get();

// $cnt=DB::table('ngosign')->count();
// $rfe=DB::table('colourcode')->where('cnt','<',$cnt)->get();

// $array=array();
// $array1=array();$array2=array();$array4=array();
// $i=0;
// foreach($ngos as $ngos)
// {
// $array[$i]=DB::table('makeevent1')->where('non',$ngos->non)->count();
// $array1[$i]=DB::table('articlehom')->where('non',$ngos->non)->where('typeofwork','dtn')->count();
// $array2[$i]=DB::table('volunteer')->where('non',$ngos->non)->count();
// $i=$i+1;
// }
// $r=$i;
// $a=DB::table('makeevent1')->count();
// $b=DB::table('articlehom')->where('typeofwork','dtn')->count();
// $c=DB::table('volunteer')->where('non','!=','')->count();

// for($j=0;$j<$r;$j++)
// {
// // $array4[$j]=((($array[$j]/$a)+($array1[$j]/$b)+($array2[$j]/$c))/3)*100;
// }

// $ngo2=DB::table('ngosign')->get();

// //return View::make('arraypassinjavascript')->with('ngo2',$ngo2)->with('array4',$array4);
    
//      $dd=DB::table('php_interview_question')->get();
     
// 	 return View::make('FINALPROJECT/frontpage')->with('dd',$dd)->with('ngo2',$ngo2)->with('array4',$array4)->with('cnt',$cnt)->with('rfe',$rfe);
   

// //return View::make('FINALPROJECT/index/volunteer');*/
// });
// //***********BLOOD DONATION
// Route::get('bloodappa',function()


// {
// return View::make('minor/blood/blooddonation');
// }






// 	);
// Route::controller('blood','BloodController');
// //*******************ABOUT US
// Route::get('aboutus',function()

// {
// 	return View::make('FINALPROJECT/index/aboutus');
// }

// 	);


// //***************FEEDBACK
// Route::post('feedback1',function()
// 	{
// $f1=Input::get('nam');
// $f2=Input::get('ema');
// $f3=Input::get('suggest');
// DB::insert("INSERT into feedback(nam,ema,suggest) VALUES(?,?,?)",array($f1,$f2,$f3));
// return Redirect::to('/');

// 	});
// //**************OUR TEAM
// Route::get('ourteam',function()

// {
// 	return View::make('FINALPROJECT/index/ourteam');
// }
// 	);
// //****************UPCOMING EVENT
// Route::get('registeredngo',function()

// {
// 	$pl1=0;
// 	$pl1=Input::get('code');
// 	$non=Input::get('hd3');
// 	$rf=DB::table('ngosign')->get();
// 	if($pl1==1 && $non!='all')
//      {
//      	$kk=DB::table('ngosign')->where('city',$non)->orderby('non','asc')->get();
//        return View::make('FINALPROJECT/index/registeredngo')->with('kk',$kk)->with('rf',$rf);
//      }
//      $kk=DB::table('ngosign')->orderby('non','asc')->get();
//        return View::make('FINALPROJECT/index/registeredngo')->with('kk',$kk)->with('rf',$rf);
// }

// 	);
// //****************REGISTERED NGO
// Route::get('upcomingevent',function()

// {
// 	$pl1=0;
// 	$pl1=Input::get('code');
// 	$non=Input::get('hd3');
// 	$rf=DB::table('ngosign')->get();
// 	if($pl1==1 && $non!='all')
//      {
//      	$kk=DB::table('makeevent1')->where('non',$non)->orderby('dateofevent','desc')->get();
//        return View::make('FINALPROJECT/index/upcomingevent')->with('kk',$kk)->with('rf',$rf);
//      }
//      $kk=DB::table('makeevent1')->orderby('dateofevent','desc')->get();
//        return View::make('FINALPROJECT/index/upcomingevent')->with('kk',$kk)->with('rf',$rf);
// }

// 	);
// //***************GALLERY
// Route::get('gallery',function()
// {
// $rf='';
// 	$pp=0;
// 	$pp=Input::get('pp1');
// 	$jj=Input::get('n8');
// 	$ly='all';
// 	if($pp==1 && $jj!=$ly)
// 	{
// 		$de=DB::table('ngosign')->where('non',$jj)->first();
        
// 		$rde=DB::table('makefile1')->where('filefield1','!=',$rf)->where('non',$jj)->get();
// 		$fde=DB::table('makeevent1')->where('fileimage1','!=',$rf)->where('ema',$de->ema)->get();

// 	}
// 	else if($pp==0 || $jj==$ly)
// 	{
// 		$rde=DB::table('makefile1')->where('filefield1','!=',$rf)->get();
// 		$fde=DB::table('makeevent1')->where('fileimage1','!=',$rf)->get();

// 	}
// 	$gg=DB::table('ngosign')->get();
// 	return View::make('FINALPROJECT/index/gallery')->with('gg',$gg)->with('rde',$rde)->with('fde',$fde);



// });
// //**************VOLUNTEER PAGE ENTRY
// Route::get('volunteer1',function()
// {
// $fr=DB::table('ngosign')->get();
// return View::make('FINALPROJECT/index/volunteer')->with('fr',$fr);
// });
// //*****************VOLUNTEER
// Route::post('volunt',function()
// {
// $e1=Input::get('nam');
// $e2=Input::get('ema');
// $e3=Input::get('mobile');
// $e4=Input::get('address');
// $e5=Input::get('city');
// $e6=Input::get('gender');
// $e7=Input::get('non');
// //DB::insert("INSERT into volunteer(nam,ema,mobile,address,city,gender,non) VALUES(?,?,?,?,?,?,?) ",array($e1,$e2,$e3,$e4,$e5,$e6,$e7));
// if($e7=="ch")
// {
// $rr=DB::table('ngosign')->get();
// $cf=0;
// $aw=" ";
// foreach ($rr as $aa) {
//    $aa="aa".$cf;
// 	$e8=Input::get($aa);
     
// 	  if($e8!=null)
//       DB::insert("INSERT into volunteer(nam,ema,non,mobile,address,city,gender,non2) VALUES(?,?,?,?,?,?,?,?)",array($e1,$e2,$e8,$e3,$e4,$e5,$e6,$e7));
//     $cf++;
// }
// }
// else
//     DB::insert("INSERT into volunteer(nam,ema,non,mobile,address,city,gender,non2) VALUES(?,?,?,?,?,?,?,?)",array($e1,$e2,"",$e3,$e4,$e5,$e6,$e7));
// //$e7=Input::get('non');

// return Redirect::to('/');
// });
// //**************STORY1
// Route::get('story1',function(){

// 	return View::make('FINALPROJECT/index/story1');
// });
// //**************STORY1
// Route::get('story2',function(){

// 	return View::make('FINALPROJECT/index/story2');
// });
// //**************STORY1
// Route::get('story4',function(){

// 	return View::make('FINALPROJECT/index/story4');
// });
// //********************WHEY WE DO
// Route::get('wheywedo',function(){

// 	return View::make('FINALPROJECT/index/wheywedo');
// });
// //**************IMAGEUPLOAD1
// Route::post('/upload', function(){

// //if (Input::file('photo')->isValid())
// //{
//     //

// 	if (Input::hasFile('avatar'))
// 	{
// 	    $file = Input::file('avatar');
// 	   return $file->getClientOriginalName();
// 	    $file->move('images', $file->getClientOriginalName());
// //$size = Input::file('avatar')->getSize();

          
// 	   // $image = Image::make(sprintf('images/%s', $file->getClientOriginalName()))->resize(200, 200)->save();
// 	}
// //}
// 	return View::make('imageupload1');
// 	//$img->insert('public/watermark.png'); ADD WATERMARK

// });
// //***********LOGINAGAIN`
// Route::post('loginagain1',function()
// {
// 	$l1=Input::get('ema');
// 	$l2=Input::get('non');
// 	$l3=Input::get('mobile');
// 	$ss1=DB::table('ngosign')->where('non',$l2)->where('ema',$l1)->where('mobile',$l3)->first();
// 	//$ss2=DB::selectOne("SELECT * FROM ngosign where non=$l2 and ema=$l1 and mobile=$l3");
	
// 	if($ss1!=null)
// 	{
// 		return View::make('FINALPROJECT/index/loginagain')->with('fq','none')->with('fr','')->with('ema',$l1);
// 	}
//      else
//      {
     	
//      	return View::make('FINALPROJECT/index/loginagain')->with('fe','SORRY YOUR INFO IS WRONG TRY AGAIN')->with('fr','none')->with('fq','')->with('ema','');
//      }
// }

// 	);

// //****************LOGIN AGAIN CHANGE PASSWORD
// Route::post('loginagain2',function()
// {
//     $l1=Input::get('ema');
// 	$l2=Input::get('pswd');
// 	$l3=Input::get('conpswd');
// 	DB::table('ngosign')->where('ema',$l1)->update(array('pswd'=>$l2,'conpswd'=>$l3));
//      return Redirect::to('/');
// }

// 	);
// //******************LOGIN AGAIN PAGE OPEN
// Route::get('loginagainpage',function()
// {
// 	return View::make('loginagain')->with('fr','none')->with('fq','')->with('ema','');
// }
// );

// //******************SIGNUP PAGE
// Route::get('newuser', function()
// {
	
// 	return View::make('signupmainpage')->with('err','');

// });

// //**************ARTICLE HOME
// Route::get('articlehome', function()
// {
// 	$fr=DB::table('ngosign')->get();
// 	return View::make('FINALPROJECT/index/articlehome')->with('fr',$fr);

// });
// //**************MONEY HOME
// Route::get('moneyhome', function()
// {
	
// 	return View::make('FINALPROJECT/index/moneyhome');

// });
// //******************LOGOUT 
// Route::post('logout', function()
// {
	
// 	return Redirect::to('/');

// });

// //********************MAKE DIRECTORY NOT USE
// Route::get('hello',function(){
// //public_path().
// 	$jj=Input::get('hh');
// 	$path = 'FINALPROJECT/'.$jj;
// File::makeDirectory($path, $mode = 0777, true, true);

// });


// //***********NOT USE
// Route::get('jk',function()

// {

// $a=Input::get('id');
// $b=Input::get('username');
// 	 DB::insert("INSERT into user(id,name1) values(?,?)",array($a,$b));
// 	 	return 'submitted';
// }

// 	);
// Route::get('share',function()

// {

  

//    $ff=DB::table('shareviews')->orderBy('syv0', 'desc')->get();
//    $rf=DB::table('replied')->orderBy('non','desc')->get();
//    return View::make('FINALPROJECT/index/sharing')->with('rf',$rf)->with('ff',$ff);

// }

// 	);

// Route::post('share1',function()

// {

//     $hjh=0;
//     $hjh=Input::get('hjh');
//     if($hjh==1)
//     {
//        $f1=Input::get('non');
//        $f2=Input::get('code');
//        $f3=Input::get('nam');
//        $f4=Input::get('view');
//        $f5=Input::get('dateofreply');

//        $rgf=DB::table('replied')->where('non',$f1)->where('code',$f2)->where('nam',$f3)->where('view',$f4)->where('dor',$f5)->get();
//        if($rgf==null)
//        {
//        	DB::insert("INSERT into replied(non,code,nam,view,dor) VALUES(?,?,?,?,?)",array($f1,$f2,$f3,$f4,$f5));
//        }
//     }

//    $ff=DB::table('shareviews')->orderBy('syv0', 'desc')->get();
//    $rf=DB::table('replied')->orderBy('non','desc')->get();
//    return View::make('FINALPROJECT/index/sharing')->with('rf',$rf)->with('ff',$ff);

// }

// 	);

// //**************SIGNUP FORM
// Route::post('ngosign',function()
// {

// 	$confirmation_code1=str_random(30);
// $l1=Input::get('non');
// $l2=Input::get('ema');
// $l3=Input::get('pswd');
// $l4=Input::get('conpswd');
// $l5=Input::get('address');
// $l6=Input::get('city');
// $l7=Input::get('pin');
// $l8=Input::get('state');
// $l9=Input::get('mobile');
// $l10=Input::get('renu');
// $l11=Input::get('secret5');
// $l12=Input::get('date5');
// $l13=Input::get('member1');
// $l14=Input::get('mobile1');
// $l15=Input::get('member2');
// $l16=Input::get('mobile2');
// $l17=Input::get('member3');
// $l18=Input::get('mobile3');
// $l19=Input::get('obj');
// $l20=Input::get('date1');
// $l21=Input::get('poe1');
// $l22=Input::get('obj1');
// $l23=Input::get('date2');
// $l24=Input::get('poe2');
// $l25=Input::get('obj2');
// $l26=Input::get('date3');
// $l27=Input::get('poe3');
// $l28=Input::get('obj3');
// $l29=Input::get('website');

// /*$de=DB::table('ngosign')->where('ema',$l2);
// if($de==null)
// {*/
// DB::insert("INSERT into ngosign(non,ema,pswd,conpswd,address,city,pin,state,mobile,renu,secret5,date5,member1,mobile1
// 	,member2,mobile2,member3,mobile3,obj,date1,poe1,obj1,date2,poe2,obj2,date3,poe3,obj3,website,confirmation_code) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
//   array($l1,$l2,$l3,$l4,$l5,$l6,$l7,$l8,$l9,$l10,$l11,$l12,$l13,$l14,$l15,$l16
// ,$l17,$l18,$l19,$l20,$l21,$l22,$l23,$l24,$l25,$l26,$l27,$l28,$l29,$confirmation_code1));



// 	$path = 'FINALPROJECTPERSONAL/'.$l1;
// File::makeDirectory($path, $mode = 0777, true, true);
// $path2=$path.'/PHOTOS';
// $path3=$path.'/VIDEOS';
// $path4=$path.'/FILES';
// $path5=$path.'/MESSAGE';
// $path6=$path.'/REQUEST';
// $path7=$path.'/VIEWS';
// File::makeDirectory($path2, $mode = 0777, true, true);
// File::makeDirectory($path3, $mode = 0777, true, true);
// File::makeDirectory($path4, $mode = 0777, true, true);
// File::makeDirectory($path5, $mode = 0777, true, true);
// File::makeDirectory($path6, $mode = 0777, true, true);	
// File::makeDirectory($path7, $mode = 0777, true, true);

// Mail::send('FINALPROJECT.welcome',array('firstname'=>$confirmation_code1),function($message) {
//             $message->to(Input::get('ema'),Input::get('ema'))
//                 ->subject('Verify Your Email Address');
//         });
// \Session::flash('flash_message','Thanks for signing up! Please check your email.');
// 		return View::make('FINALPROJECT/welcome1');
// //return Redirect::to('/');
// }

// 	);

// //*****************EMAIL CONFRIRMATION CODE
// Route::get('register/verify/{confirmationCode}',function($confirmationCode)
// {
//       $logindata=DB::table('ngosign')->get();
//       $a1=0;
//       foreach ($logindata as $row) 
//       {
//          if ($row->confirmation_code==$confirmationCode) 
//          {

//           DB::update("UPDATE ngosign SET confirmation_code=?,confirmed=? where confirmation_code=?",array('null',1,$confirmationCode));
//             $a1=1;
//             return Redirect::to('/');
//          }
//       }
//       if($a1==0)
//       {
//         dd('There is some problem with the Verification link.Please Sign Up Again');
//       } 
// });
// //*****************EMAIL CONFRIRMATION CODE

// //*************LOGIN FORM
// Route::post('ngo',function()
// {

// $aa=Input::get('email1');
// $b=Input::get('pswd');
// $p234=0;
// $count1=0;
// $k234=0;
// $p909=0;
// $k234=Input::get('k234');
// $p234=Input::get('pp');
// $p909=Input::get('p909');
// if($p909==1)
// {
// 	$syv0=DB::table('shareviews')->count();
// 	$syv0='codeof'.$syv0; 
// 	$syv1=Input::get('non');
// 	$syv2=Input::get('ema');
// 	$syv3=Input::get('dateofwrite');
// 	$syv4=Input::get('timeofwrite');
// 	$syv5=Input::get('whatsinyourmind');
// 	$aaa5='FINALPROJECTPERSONAL/'.$syv1.'/VIEWS';
// 	if (Input::hasFile('fileimage5'))
// 	{
// 	    $file = Input::file('fileimage5');
// 	     $syv6=$file->getClientOriginalName();

// 	     $count1=1;
	    
// 	  }
// 	  else
// 	  {
// 	  	$syv6="";
// 	  }
// 	  $rrrt=DB::table('shareviews')->where('syv1',$syv1)->where('syv2',$syv2)->where('syv3',$syv3)->where('syv4',$syv4)->where('syv5',$syv5)->where('syv6',$syv6)->get();
	  
// 	  if($rrrt==null)
// 	  {
// 	  	DB::insert("INSERT into shareviews(syv0,syv1,syv2,syv3,syv4,syv5,syv6) VALUES(?,?,?,?,?,?,?)",array($syv0,$syv1,$syv2,$syv3,$syv4,$syv5,$syv6));
//           if($count1==1)
// $file->move($aaa5, $file->getClientOriginalName());
// 	  }
	
// }
// if($k234==1)
// {
// 	$h1=Input::get('n1');
//     $h2=Input::get('n2');
//  $ss2=DB::table('ngosign')->where('ema',$h1)->first();
//     $h3=Input::get('n3');
//     $h4=Input::get('n8');
//     $h5=Input::get('n6');
//     $h6=Input::get('n7');
//     if($h4=='dtn')
//     {
//     	$rr=DB::table('ngosign')->get();
// $cf1=0;
// $aw=" ";
// foreach ($rr as $aa6) {
//    $aa7="aa".$cf1;
//    $aa8="bb".$cf1;
//    $aa9="cc".$cf1;
// 	$e8=Input::get($aa7);
//     $e9=Input::get($aa8);
//     $e10=Input::get($aa9); 
//     $rr1=DB::table('ngodonation')->where('ngoname',$ss2->non)->where('dontype',"dtn")->where('otherngo',$e8)->where('articlename',$e10)->where('quantity',$e9)->get();
	
// 	  if($e8!=null&&$rr1==null)
//       DB::insert("INSERT into ngodonation(ngoname,dontype,otherngo,articlename,quantity) VALUES(?,?,?,?,?)",array($ss2->non,"dtn",$e8,$e10,$e9));
//     $cf1++;
// }
//     }
//     else
//     {
//     	 $rr1=DB::table('ngodonation')->where('ngoname',$ss2->non)->where('dontype',"adv")->where('otherngo',"")->where('articlename',$h5)->where('quantity',$h6)->get();
//     	 if($rr1==null)
//        	DB::insert("INSERT into ngodonation(ngoname,dontype,otherngo,articlename,quantity) VALUES(?,?,?,?,?)",array($ss2->non,"adv","",$h5,$h6));
//     }
// }
// if($p234==1)
// {
	
//    $aa=Input::get('email12');
//    //$b=Input::get('pswd12');

//    $ss1=DB::table('ngosign')->where('ema',$aa)->first();
  
//    $aa5='FINALPROJECTPERSONAL/'.$ss1->non.'/MESSAGE';
//    $l1=Input::get('non');
//    $l2=Input::get('otherngo');
//    $l3=Input::get('message');
//    if (Input::hasFile('fileimage1'))
// 	{
// 	    $file = Input::file('fileimage1');
// 	     $l4=$file->getClientOriginalName();

// 	     $count1=1;
// 	  }
// 	  else
// 	  {
// 	  	$l4="";
// 	  }
// 	if($count1==1)
// 		{
// $file->move($aa5, $file->getClientOriginalName());}  

//    if($l2==null)
//    {
    
// $rr=DB::table('ngosign')->get();
// $cf=0;
// $aw=" ";
// foreach ($rr as $aa6) {
//    $aa7="aa".$cf;
// 	$e8=Input::get($aa7);
//      $rr=DB::table('message')->where('ngoname',$ss1->non)->where('ngotype',"group")->where('otherngo',$e8)->where('message',$l3)->where('fileimage1',$l4)->get();
	 
// 	  if($e8!=null&&$rr==null)
//       DB::insert("INSERT into message(ngoname,ngotype,otherngo,message,fileimage1) VALUES(?,?,?,?,?)",array($ss1->non,"group",$e8,$l3,$l4));
//     $cf++;
// }

//    }
//    else
//    {
//    	$rr=DB::table('message')->where('ngoname',$ss1->non)->where('ngotype',"single")->where('otherngo',$l2)->where('message',$l3)->where('fileimage1',$l4)->get();
//    if($rr==null)
//    	DB::insert("INSERT into message(ngoname,ngotype,otherngo,message,fileimage1) VALUES(?,?,?,?,?)",array($ss1->non,"single",$l2,$l3,$l4));
//    }

// }
// if($p234==1)
// $ss=DB::table('ngosign')->where('ema',$ss1->ema)->where('pswd',$ss1->pswd)->first();
// else if($k234==1)
// $ss=DB::table('ngosign')->where('ema',$ss2->ema)->where('pswd',$ss2->pswd)->first();
// else if($p909==1)
// $ss=DB::table('ngosign')->where('ema',$syv2)->first();	
// else
// $ss=DB::table('ngosign')->where('ema',$aa)->where('pswd',$b)->where('confirmed',1)->first();

// if($ss!=null)
// {   $reqevn=DB::table('requestevent1')->where('ngoname',$ss->non)->orderby('eventnumber','desc')->get();
// 	$dn=DB::table('ngodonation')->where('otherngo',$ss->non)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
// 	$aw=DB::table('donationaccept')->where('ngoemail',$aa)->get();
//     $ty=DB::table('volunteer')->where('non',$ss->non)->get();
//     $cnt=DB::table('volunteer')->where('non',$ss->non)->count();
//         $try=DB::table('volunteer')->get();
// 	$ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ss->non)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
// $mes=DB::table('message')->where('otherngo',$ss->non)->get();
// $mescount=DB::table('message')->where('otherngo',$ss->non)->count();
// $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
// $ggg=DB::table('ngosign')->get();
// $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ss->non)->count();
 
// 	return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$ss->non)->with('city',$ss->city)->with('ema',$ss->ema)->with('kk',$kk)->with('ggg',$ggg)->with('pswd2',$b);
// }
// else
// {
// 	return Redirect::to('/');
// 	//return 'hello';
// }

// }
// 	);
// //*******************MAKE EVENT 1
// Route::post('makeevent1',function()

// {
// 	//$dd=DB::table('php_interview_question')->get();
//     $l7=Input::get('non');
//     $aa='FINALPROJECTPERSONAL/'.$l7.'/PHOTOS';
// 	$l1=Input::get('ema');
//     $l2=Input::get('topic');
// 	$l3=Input::get('dateofevent');
// 	$l4=Input::get('address');
// 	$l5=Input::get('mobile');
// 	$l9=Input::get('mobile2');
// 	$l6=Input::get('descript');
// 	$ll=Input::get('city');
// 	$l10=Input::get('city2');
// 	$l8='';
// 	$count=0;
// 	$rd=DB::table('ngosign')->where('non',$l7)->first();
// 	if (Input::hasFile('fileimage1'))
// 	{
// 	    $file = Input::file('fileimage1');
	    
//          $l8=$file->getClientOriginalName();
//      $count=1;
// 	 }
// 	$pp=DB::table('makeevent1')->where('ema',$l1)->where('topic',$l2)->where('dateofevent',$l3)->where('address',$l4)->where('mobile',$l5)->where('descript',$l6)->where('non',$l7)->where('fileimage1',$l8)->where('city2',$l10)->first(); 
// 	if($pp==null)
// 	{
// 		if($count==1)
// 		{
// $file->move($aa, $file->getClientOriginalName());}
// DB::insert("INSERT into makeevent1(ema,topic,dateofevent,address,mobile,descript,non,fileimage1,mobile2,city2) VALUES(?,?,?,?,?,?,?,?,?,?)",array($l1,$l2,$l3,$l4,$l5,$l6,$l7,$l8,$l9,$l10));
// }
// $dn=DB::table('ngodonation')->where('otherngo',$l7)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
// $ty=DB::table('volunteer')->where('non',$l7)->get();
//     $cnt=DB::table('volunteer')->where('non',$l7)->count();
//         $try=DB::table('volunteer')->get();
// $aw=DB::table('donationaccept')->where('ngoemail',$l1)->get();
// $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l7)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $mes=DB::table('message')->where('otherngo',$l7)->get();
// $mescount=DB::table('message')->where('otherngo',$l7)->count();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
// $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
// $ggg=DB::table('ngosign')->get();
// $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l7)->count();
// $reqevn=DB::table('requestevent1')->where('ngoname',$l7)->orderby('eventnumber','desc')->get();
// return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$l7)->with('city',$ll)->with('ema',$l1)->with('kk',$kk)->with('ggg',$ggg)->with('pswd2',$rd->pswd);

// }
// );


// //REQUEST EVENT
// Route::post('requestevent1',function()

// {
// 	//$dd=DB::table('php_interview_question')->get();
//     $l7=Input::get('non');
//     $aa='FINALPROJECTPERSONAL/'.$l7.'/REQUEST';
// 	$l1=Input::get('ema');
//     $l2=Input::get('topic');
// 	$l3=Input::get('dateofevent');
// 	$l4=Input::get('address');
// 	$l5=Input::get('mobile');
// 	$l9=Input::get('mobile2');
// 	$l6=Input::get('descript');
// 	$ll=Input::get('city');
// 	$l10=Input::get('city2');
// 	$l8='';
// 	$count=0;
// 	$rd=DB::table('ngosign')->where('non',$l7)->first();
// 	if (Input::hasFile('fileimage1'))
// 	{
// 	    $file = Input::file('fileimage1');
	    
//          $l8=$file->getClientOriginalName();
//      $count=1;
// 	 }
// 	$pp=DB::table('requestevent1')->where('ema',$l1)->where('topic',$l2)->where('dateofevent',$l3)->where('address',$l4)->where('mobile',$l5)->where('descript',$l6)->where('non',$l7)->where('fileimage1',$l8)->where('city2',$l10)->first(); 
// 	if($pp==null)
// 	{

// 		if($count==1)
// 		{
// $file->move($aa, $file->getClientOriginalName());
// }
// $rgt=DB::table('requestevent1')->count();
// $rgt++;
// $rgg="Eve".$rgt;


// $rr1=DB::table('ngosign')->get();
// $cf=0;
// $aw=" ";

// foreach ($rr1 as $aa6) {
//    $aa7="hh".$cf;
// 	$e8=Input::get($aa7);
//    //  $rr1=DB::table('requestevent1')->where('eventnumber',$rgg)->where('ngoname',$e8);	 
// 	  if($e8!=null)
//       {
//       	DB::insert("INSERT into requestevent1(eventnumber,ema,topic,dateofevent,address,mobile,descript,non,fileimage1,mobile2,city2,ngoname,flag1) 
// 	VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)",array($rgg,$l1,$l2,$l3,$l4,$l5,$l6,$l7,$l8,$l9,$l10,$e8,"1"));
//     }
//     $cf++;
// }


// }
// $reqevn=DB::table('requestevent1')->where('ngoname',$l7)->orderby('eventnumber','desc')->get();
// $dn=DB::table('ngodonation')->where('otherngo',$l7)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
// $ty=DB::table('volunteer')->where('non',$l7)->get();
//     $cnt=DB::table('volunteer')->where('non',$l7)->count();
//         $try=DB::table('volunteer')->get();
// $aw=DB::table('donationaccept')->where('ngoemail',$l1)->get();
// $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l7)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $mes=DB::table('message')->where('otherngo',$l7)->get();
// $mescount=DB::table('message')->where('otherngo',$l7)->count();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
// $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
// $ggg=DB::table('ngosign')->get();
// $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l7)->count();
// return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$l7)->with('city',$ll)->with('ema',$l1)->with('kk',$kk)->with('ggg',$ggg)->with('pswd2',$rd->pswd);

// }
// );

// //****************************MAKE FILE1 NGO PAGE
// Route::post('makefile1',function()
// {
// $l4=Input::get('city');
// 	$l2=Input::get('non');
//     $aa='FINALPROJECTPERSONAL/'.$l2.'/FILES';
// 	$l1=Input::get('ema');
// 	$dd=DB::table('php_interview_question')->get();
// 	$rd=DB::table('ngosign')->where('non',$l2)->first();
// 	if (Input::hasFile('filefield1'))
// 	{
// 	    $file = Input::file('filefield1');
// 	     $l3=$file->getClientOriginalName();
// 	  }

// $pp=DB::table('makefile1')->where('ema',$l1)->where('non',$l2)->where('filefield1',$l3)->first();
// 	if($pp==null)
// 	{
// 	    $file->move($aa, $file->getClientOriginalName());
        

	   
	
// 	DB::insert("INSERT into makefile1(ema,non,filefield1) VALUES(?,?,?)",array($l1,$l2,$l3));
//      }
//      $reqevn=DB::table('requestevent1')->where('ngoname',$l2)->orderby('eventnumber','desc')->get();
//      $dn=DB::table('ngodonation')->where('otherngo',$l2)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
//      $ty=DB::table('volunteer')->where('non',$l2)->get();
//     $cnt=DB::table('volunteer')->where('non',$l2)->count();
//         $try=DB::table('volunteer')->get();
//      $aw=DB::table('donationaccept')->where('ngoemail',$l1)->get();
//      $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
//     $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
//     $mes=DB::table('message')->where('otherngo',$l2)->get();
// $mescount=DB::table('message')->where('otherngo',$l2)->count();
//     $ggg=DB::table('ngosign')->get();
//     $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l2)->get();
//     $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l2)->count();
//     return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('ee',$ee)->with('pvp',$pvp)->with('rr',$rr)->with('non',$l2)->with('city',$l4)->with('ema',$l1)->with('kk',$kk)->with('ggg',$ggg)->with('pswd2',$rd->pswd);
// });
// //********************************MAKE VIDEO1 NGO PAGE AND USE UPLOAD FILE
// Route::post('makevideo1',function()
// {
// 	$l4=Input::get('city');
// 	$l2=Input::get('non');
//     $aa='FINALPROJECTPERSONAL/'.$l2.'/VIDEOS';
// 	$l1=Input::get('ema');
// $rd=DB::table('ngosign')->where('non',$l2)->first();

// 	if (Input::hasFile('video1'))
// 	{
// 	    $file = Input::file('video1');
// 	    $l3=$file->getClientOriginalName();
// 	}

// 	$pp=DB::table('makevideo1')->where('ema',$l1)->where('non',$l2)->where('fileToUpload1',$l3)->first();
// 	if($pp==null)
// 	{
// 	     $file->move($aa, $file->getClientOriginalName());
	
	  
// 	   DB::insert("INSERT into makevideo1(ema,non,fileToUpload1) VALUES(?,?,?)",array($l1,$l2,$l3));
//     } 
//     $reqevn=DB::table('requestevent1')->where('ngoname',$l2)->orderby('eventnumber','desc')->get();
//     $dn=DB::table('ngodonation')->where('otherngo',$l2)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
//     $ty=DB::table('volunteer')->where('non',$l2)->get();
//     $cnt=DB::table('volunteer')->where('non',$l2)->count();
//         $try=DB::table('volunteer')->get();
//     $aw=DB::table('donationaccept')->where('ngoemail',$l1)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
//     $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
//     $ggg=DB::table('ngosign')->get();
//     $mes=DB::table('message')->where('otherngo',$l2)->get();
// $mescount=DB::table('message')->where('otherngo',$l2)->count();
//     $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l2)->get();
//     $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$l2)->count();
    
//   return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$l2)->with('city',$l4)->with('kk',$kk)->with('ema',$l1)->with('ggg',$ggg)->with('pswd2',$rd->pswd);
// //return Redirect::to('ngo');
// });
// //*************************************ARTICLE HOME
// Route::post('articlehom',function()

// {

// $flag1=1;
// 	$n1=Input::get('n1');
// 	$n2=Input::get('n2');
// 	$n3=Input::get('n3');
// 	$n4=Input::get('n4');
// 	$n5=Input::get('n5');
// 	$n6=Input::get('n6');
// 	$n7=Input::get('n7');
// 	$n8=Input::get('n8');
	

	
// 	//DB::insert("INSERT into articlehom(email,name,address,city,mobile,articlename,quantity,typeofwork,flag1) VALUES(?,?,?,?,?,?,?,?,?)",array($n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$flag1));
//     if($n8=="dtn")
// {
// $rr=DB::table('ngosign')->get();
// $cf=0;

// foreach ($rr as $aa) {
//    $aa="aa".$cf;
//    $bb="bb".$cf;
//    $cc="cc".$cf;
// 	$e8=Input::get($aa);
// 	$e9=Input::get($bb);
//      $e10=Input::get($cc);
// 	  if($e8!=null)
//       DB::insert("INSERT into articlehom(nam,ema,non,quantity,flag1,article,address,city,mobile,typeofwork) VALUES(?,?,?,?,?,?,?,?,?,?)",array($n2,$n1,$e8,$e9,$flag1,$e10,$n3,$n4,$n5,$n8));
//     $cf++;
// }
// }
// else
// 	 DB::insert("INSERT into articlehom(nam,ema,non,quantity,flag1,article,address,city,mobile,typeofwork) VALUES(?,?,?,?,?,?,?,?,?,?)",array($n2,$n1,"",$n7,$flag1,$n6,$n3,$n4,$n5,$n8));
//    return Redirect::to('/');
// }
// 	);

// //*************************************MONEY HOME
// Route::post('moneyhom',function()

// {
// 	$n1=Input::get('n1');
// 	$n2=Input::get('n2');
// 	$n3=Input::get('n3');
// 	$n4=Input::get('n4');
// 	$n5=Input::get('n5');
// 	$n6=Input::get('n6');
// 	$n7='1';


// 	DB::insert("INSERT into moneyhom(email,name,address,city,mobile,money1,flag1) VALUES(?,?,?,?,?,?,?)",array($n1,$n2,$n3,$n4,$n5,$n6,$n7));
//    return Redirect::to('/');
// }
// 	);
// //*********************DELETE FORM NGO
// Route::post('deleteform1',function()
// {
// $l1=Input::get('ema');
// $l2=Input::get('non');
// $l3=Input::get('pswd');
// $l4=Input::get('conpswd');
// $ff=DB::table('ngosign')->where('ema',$l1)->where('pswd',$l3)->where('conpswd',$l4);
// if($ff!=null)
// {
// 	$directory1='FINALPROJECTPERSONAL/'.$l2;
//  DB::table('makeevent1')->where('ema',$l1)->delete();
//  DB::table('makevideo1')->where('ema',$l1)->delete();
//  DB::table('makefile1')->where('ema',$l1)->delete();
//  DB::table('ngosign')->where('ema',$l1)->delete();
//  $success = File::deleteDirectory($directory1);
//  return View::make('FINALPROJECT/ngo/deletedngo')->with('vvv','Your Details And All Data Has Been Deleted ......        Thanks Be Part Of Light The Future');
// }

// else
//  {
//  	return View::make('FINALPROJECT/ngo/deletedngo')->with('vvv','DETAILS YOU HAVE ENTERED TO DELETE ID IS WRONG..... Your Id is Not Deleted');
// }

// }
// 	);
// //****************DELETED ID AND GO BACK HOME
// Route::get('deletehome',function()
// {
// 	return Redirect::to('/');
// }

// 	);
// //**************DONATIONACCEPT ARTICLE
// Route::post('donationacceptarticle',function()
// {
//   $r1=Input::get('ema');
//   $r2=Input::get('email');
//   $r3=Input::get('nam');
//   $r4=Input::get('mobile');
//   $r5='article';
//   $r6=Input::get('articlename');
//   $r7=Input::get('address');
//   $r8=Input::get('quantity');
//   $ssd=DB::table('ngosign')->where('ema',$r1)->first();
//   $lop=DB::table('donationaccept')->where('ngoemail',$r1)->where('manemail',$r2)->where('typeofdon',$r5)->where('name',$r3)->where('mobile',$r4)->where('address',$r7)->get();
//   if($lop==null)
//   {
//   DB::insert("INSERT into donationaccept(ngoemail,manemail,typeofdon,name,mobile,address,thing,quantity) VALUES(?,?,?,?,?,?,?,?)",array($r1,$r2,$r5,$r3,$r4,$r7,$r6,$r8));}
// DB::table('articlehom')->where('ema',$r2)->where('article',$r6)->update(array('flag1'=>'0'));
// $dn=DB::table('ngodonation')->where('otherngo',$ssd->non)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
// 	$reqevn=DB::table('requestevent1')->where('ngoname',$ssd->non)->orderby('eventnumber','desc')->get();
// $ty=DB::table('volunteer')->where('non',$ssd->non)->get();
//     $cnt=DB::table('volunteer')->where('non',$ssd->non)->count();
//         $try=DB::table('volunteer')->get();
// $aw=DB::table('donationaccept')->where('ngoemail',$r1)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
//     $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
//     $mes=DB::table('message')->where('otherngo',$ssd->non)->get();
// $mescount=DB::table('message')->where('otherngo',$ssd->non)->count();
//     $ggg=DB::table('ngosign')->get();
//     $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ssd->non)->get();
//     $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ssd->non)->count();
    
//    return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$ssd->non)->with('city',$ssd->city)->with('kk',$kk)->with('ema',$r1)->with('ggg',$ggg)->with('pswd2',$ssd->pswd);
// }
// );
// //************DONATION ACCEPT MONEY
// Route::post('donationacceptmoney',function()
// {
//   $r1=Input::get('ema');
//   $r2=Input::get('email');
//   $r3=Input::get('nam');
//   $r4=Input::get('mobile');
//   $r5='money';
//   $r6=Input::get('money1');
//   $r7=Input::get('address');
//   $r8='';
//   $ssd=DB::table('ngosign')->where('ema',$r1)->first();
//   $lop=DB::table('donationaccept')->where('ngoemail',$r1)->where('manemail',$r2)->where('typeofdon',$r5)->where('name',$r3)->where('mobile',$r4)->where('address',$r7)->get();
//   if($lop==null)
//   {
//   DB::insert("INSERT into donationaccept(ngoemail,manemail,typeofdon,name,mobile,address,thing,quantity) VALUES(?,?,?,?,?,?,?,?)",array($r1,$r2,$r5,$r3,$r4,$r7,$r6,$r8));}
// DB::table('moneyhom')->where('email',$r2)->where('money1',$r6)->update(array('flag1'=>'0'));
// $ty=DB::table('volunteer')->where('non',$ssd->non)->get();
// $dn=DB::table('ngodonation')->where('otherngo',$ssd->non)->where('dontype',"dtn")->get();
// 	$dn1=DB::table('ngodonation')->where('dontype',"adv")->get();
// 	$reqevn=DB::table('requestevent1')->where('ngoname',$ssd->non)->orderby('eventnumber','desc')->get();
//     $cnt=DB::table('volunteer')->where('non',$ssd->non)->count();
//         $try=DB::table('volunteer')->get();
// $aw=DB::table('donationaccept')->where('ngoemail',$r1)->get();
// $rr=DB::table('articlehom')->where('flag1',1)->where('typeofwork','adv')->get();
// $oo=DB::table('moneyhom')->where('flag1',1)->get();	
//     $kk=DB::table('makeevent1')->orderBy('dateofevent', 'desc')->get();
//     $mes=DB::table('message')->where('otherngo',$ssd->non)->get();
// $mescount=DB::table('message')->where('otherngo',$ssd->non)->count();
//     $ggg=DB::table('ngosign')->get();
//     $ee=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ssd->non)->get();
//     $pvp=DB::table('articlehom')->where('flag1',1)->where('typeofwork','dtn')->where('non',$ssd->non)->count();
    
//   return View::make('FINALPROJECT/ngo')->with('reqevn',$reqevn)->with('ty',$ty)->with('try',$try)->with('cnt',$cnt)->with('dn',$dn)->with('dn1',$dn1)->with('mes',$mes)->with('mescount',$mescount)->with('aw',$aw)->with('oo',$oo)->with('rr',$rr)->with('pvp',$pvp)->with('ee',$ee)->with('non',$ssd->non)->with('city',$ssd->city)->with('kk',$kk)->with('ema',$r1)->with('ggg',$ggg)->with('pswd2',$ssd->pswd);
//    // return Redirect::to('/ngo');
// }
// );
// //************NO USE DELETE DIRECTORY

// Route::get('hello1',function()
// {
// 	$directory1='sachdeva';	$success = File::deleteDirectory($directory1);
// }
// 	);






