<?php 
class Reports_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		
		$this->load->database();
	}

	public function product($from_date, $to_date){
		$sql = 
		"SELECT p.pro_id, COUNT(p.pro_id) AS count, p.pro_name, p.pro_list_price, p.pro_sale_price, SUM(od.orderDetail_quantity) AS quantity
		FROM (
			(SELECT * FROM tbl_orders WHERE order_time >= '$from_date' AND order_time <= '$to_date' AND order_status = 1) AS o	
			LEFT JOIN tbl_orderDetails AS od ON od.order_id = o.order_id
            INNER JOIN tbl_products AS p ON od.pro_id = p.pro_id
		) GROUP BY od.pro_id ORDER BY count DESC, quantity DESC
		";

		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	public function category($from_date, $to_date){
		$sql = 
		"SELECT cate.cate_id, count(cate.cate_id) as count, cate.cate_name, SUM(od.orderDetail_quantity) as quantity
		FROM (
			(SELECT * FROM tbl_orders WHERE order_time >= '$from_date' AND order_time <= '$to_date' AND order_status = 1) AS o
			LEFT JOIN tbl_orderDetails AS od ON od.order_id = o.order_id
			INNER JOIN tbl_procate AS pc ON od.pro_id = pc.pro_id
			LEFT JOIN tbl_categories as cate ON pc.cate_id = cate.cate_id
		) GROUP BY cate.cate_id ORDER BY count DESC
		";

		$query = $this->db->query($sql);
		return $query->result_array();	
	}
}