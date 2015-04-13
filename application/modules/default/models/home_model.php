<?php
class Home_model extends CI_Model {
	protected $_sliders    = "tbl_sliders";
	protected $_product    = "tbl_products";
	protected $_brand      = "tbl_brands";
	protected $_image      = "tbl_images";
	protected $_feedback   = "tbl_feedback";
    protected $_cate       = "tbl_categories";
    protected $_procate    = "tbl_procate";
    
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->helper ( "url" );
	}
	public function get_list_slider() {
		$this->db->select ( "*" );
		$this->db->join ( $this->_product, $this->_sliders . '.pro_id =' . $this->_product . '.pro_id' );
		$this->db->order_by ( "img_order", "ASC" );
		$this->db->limit ( 3 );
		$query = $this->db->get ( $this->_sliders );
		return $query->result_array ();
	}
	public function get_one_record($id) {
		$sql = "SELECT * FROM $this->_product as P
                JOIN $this->_brand as B ON P.brand_id=B.brand_id
                JOIN $this->_image as I ON P.pro_id=I.pro_id
                WHERE P.pro_id=$id
                ";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
	}
   
	// get product with filter
	public function insert_feedback($feed_back) {
		$this->db->insert ( $this->_feedback, $feed_back );
		return $this->db->insert_id ();
	}
	public function get_rating_avg($pro_id) {
		$this->db->select_avg ( 'feed_rate' );
		$this->db->where ( 'pro_id', $pro_id );
		$query = $this->db->get ( $this->_feedback );
		return $query->result_array ();
	}
	public function get_comments($pro_id) {
		$this->db->where('pro_id', $pro_id);
		$this->db->where('status', 1);
		$this->db->order_by ( "feed_time", "desc" );
		$query = $this->db->get($this->_feedback);
		return $query->result_array();
	}
	
	public function get_products_by_brand($brand = array(), $start, $limit) {
		$this->db->select ( "*" );
		$this->db->where_in ( 'brand_id', $brand );
        $this->db->limit($limit, $start);
		$query = $this->db->get ( $this->_product );
		return $query->result_array ();
	}
    
    public function get_total_record($cate_id = ''){
    	if($cate_id=='')
        {
            $query = $this->db->get($this->_product);
            return $query->num_rows();    
        }
        else
        {
            $child = $this->get_cate_child($cate_id);
            $this->db->where_in('cate_id',$child);
            $this->db->select("pro_id");
            $this->db->distinct();
            $query = $this->db->get("tbl_procate");
            return $query->num_rows(); 
        }
    }
    
    public function get_products_limit($start, $limit='', $pro_id_arr=''){
        if($pro_id_arr=='')
        {
            $this->db->select("*");
        	if($limit!='') $this->db->limit($limit, $start);
        	$this->db->from($this->_product);
        	$this->db->join($this->_brand, $this->_product.'.brand_id ='.$this->_brand.'.brand_id');
        	$query = $this->db->get();
        	return $query->result_array();    
        }
        else
        {            
            //lay ra cac product
            if($pro_id_arr == array()) return '';
            if($limit!='') $this->db->limit($limit, $start);
            $this->db->where_in('pro_id', $pro_id_arr);
        	$this->db->join('tbl_brands', 'tbl_products.brand_id = tbl_brands.brand_id', 'left');
            $data = $this->db->get('tbl_products')->result_array();
            return $data;
        }
        
    }
    
    public function get_all_brand(){
        $this->db->select("*");
        $query = $this->db->get($this->_brand);
        return $query->result_array();
    }
    
    public function get_all_brand_by_id(){
        $this->db->select("brand_id");
        $query = $this->db->get($this->_brand);
        return $query->result_array();
    }
    
    //get product with filter
    public function get_by_filter($low, $heigh, $start, $limit){
    	$this->db->select("*");
    	$this->db->where('pro_sale_price >', $low);
    	$this->db->where('pro_sale_price <', $heigh);
    	$this->db->limit($limit, $start);
    	$query = $this->db->get($this->_product);
    	return $query->result_array();
    }    
    public function get_list_cate() {
        //lay ra danh sach cate va add level cho chung
        $list = $this->get_cates();
        
        //dem so san pham cho moi cate
        $cate_arr = array();
        foreach($list as $key=>$value)
        {
            $cate_arr[] = $value;
        }
        foreach($cate_arr as $key=>$cate)
        {
            //lay danh sach con cho moi cate
            $child_arr = array();
            $child_arr[] = $cate['cate_id'];
            for($i=1;1;$i++)
            {
                $next = isset($cate_arr[$key+$i]) ? $cate_arr[$key+$i] : '';
                if($next=='') break;
                if($next['level']>$cate['level']) $child_arr[] = $next['cate_id'];
                else break;
            }
            
            //dem so san pham cho moi cate
            $this->db->where_in('cate_id',$child_arr);
            $this->db->select("pro_id");
            $this->db->distinct();
            $query = $this->db->get("tbl_procate");
            $cate_arr[$key]['count'] = $query->num_rows();           
        }
        
        return $cate_arr;
    }
   
    public function get_all_cate_by_id(){
        $this->db->select("cate_id");
        $query = $this->db->get($this->_cate);
        return $query->result_array();
    }
   
    private function get_cates()
    {
        //lay ra danh sach cate va add level cho chung
        $this->db->order_by("cate_orderby");
        $cate_arr = $this->db->get("tbl_categories")->result_array();
        $list = array();
        foreach($cate_arr as $key=>$value)
        {
            $list[$value['cate_id']] = $value;
        }
        foreach($list as $key=>$value)
        {
            if($value['parent_id']==0)
            {
                $list[$key]['level'] = 0;
            }
            else
            {
                $list[$key]['level'] = $list[$value['parent_id']]['level'] + 1;
            }
        }
        return $list;
   }  
   
   public function get_cate_child($id)
   {
        $list = $this->get_cates();
        $child_arr = array();
        $current = $list[$id];
        $cate_arr = array();
        $i = 0;
        foreach($list as $key=>$value)
        {
            $cate_arr[++$i] = $value;            
        }
        $child_arr[] = $current['cate_id'];
        for($i=$current['cate_orderby']+1;1;$i++)
        {
            $next = isset($cate_arr[$i]) ? $cate_arr[$i] : '';
            if($next=='') break;
            if($next['level']>$current['level'])$child_arr[] = $next['cate_id'];
            else break;
        }
        return $child_arr; 
    }
    
    public function get_cate_products($start, $limit, $cate_id)
    {
        //lay id cac product thuoc cate            
        $child = $this->get_cate_child($cate_id);
        $this->db->where_in('cate_id',$child);
        $this->db->select("pro_id");
        $this->db->distinct();
        $pro_id_arr = $this->db->get("tbl_procate")->result_array();
        foreach($pro_id_arr as $key=>$value)
        {
            $pro_id_arr[$key] = $value['pro_id'];
        }
        $data = $this->get_products_limit($start, $limit, $pro_id_arr);
        return $data;
    }        
   
    public function get_all_products($cate_id, $brands, $low_price, $heigh_price, $start, $limit){
        $listBrand = implode(",", $brands);
        $listCate  = implode(",", $cate_id);
        $sql = "SELECT * FROM $this->_product as P
                LEFT JOIN $this->_procate as PC ON PC.pro_id = P.pro_id
                LEFT JOIN $this->_cate as C ON C.cate_id = PC.cate_id
                WHERE P.brand_id IN($listBrand)
                AND C.cate_id IN($listCate)
                AND P.pro_sale_price < $heigh_price
                AND P.pro_sale_price > $low_price
                LIMIT $start, $limit
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}