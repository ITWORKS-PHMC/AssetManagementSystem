<?php                
$con = new mysqli('localhost','root','','assetmanagement');
$display_query = "select id,title,schedule_date,end_date from scheduling ";             
$results = mysqli_query($con,$display_query);   
$count = mysqli_num_rows($results);  


// display schedule dates for task 
if($count>0) 
{
	$data_arr=array();
    $i=1;
	while($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	{	
	$data_arr[$i]['id'] = $data_row['id'];
	$data_arr[$i]['title'] = $data_row['title'];
	$data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['schedule_date']));
	$data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['end_date']));
	$data_arr[$i]['color'] = '#640a00'; 
	$data_arr[$i]['url'] = '#';
	$i++;
	} 
	$data = array(
                'status' => true,
                'msg' => 'successfully!',
				'data' => $data_arr
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Error!'				
            );
}
echo json_encode($data);
?>