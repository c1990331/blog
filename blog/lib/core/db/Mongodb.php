<?php
namespace core\db;

use core\Config;

class Mongodb
{
	
	protected $db;
	
	protected $_serialized = array();
	
	protected $_id;
	
	protected $error;
	
	protected $dbprefix = '';
	private static $database;
	
	private static $collection; 
	
	private static $writeConcern;
	/**
	 * Default config
	 *
	 * @static
	 * @var	array
	 */
	protected static $_default_config = array(
			'socket_type' => 'mongodb',
			'host' => '127.0.0.1',
			'username' => false,
			'password' => false,
			'port' => 27017,
			'timeout' =>0,
			'database' =>'test',
	);
	public function __construct()
	{
		if ( ! $this->is_supported())
		{
			throwException('error', 'Cache: Failed to create Redis object; extension not loaded?');
			return;
		}
		
	    if (isset(Config::get('database')['mongodb']))
		{
		    $config = array_merge(self::$_default_config, Config::get('database')['mongodb']);
		}
		else
		{
			$config = self::$_default_config;
		}
		
		try
		{
    		$link = $config['socket_type'].'://'.$config['host'].':'.$config['port'];
    		$this->db = new  \MongoDB\Driver\Manager($link);
    		self::$database = $config['database'];
    		self::$collection = new \MongoDB\Driver\BulkWrite;
    		self::$writeConcern =  new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1);
		}
		catch (\MongoException $e)
		{
			echo $e->getMessage();
		}
	}
	/**
	 * 插入文档  直接插入新文档 主键重复不做任何操作
	 * @return boolean
	 */
	public function insert($collection,$data,$keyprimary='id'){
		try{
		    $num = count($data);
		    $nums = count($data,1);
		    if($num == $nums && $num > 0){
    		   self::$collection->insert($data);
		    }else if($num>0){
                foreach($data as $va){
                    self::$collection->insert($va);
                }
		    }
		    $result = $this->db->executeBulkWrite(self::$database.'.'.$collection, self::$collection, self::$writeConcern);
		    return $result;
		}catch(\MongoCursorException $e){
			echo $e->getMessage();
			exit;
		}
	}
	/**
	 * 更新文档
	 * @param multi 默认是false,只更新找到的第一条记录，如果这个参数为true,就把按条件查出来多条记录全部更新。  
	 * @param upsert  这个参数的意思是，如果不存在update的记录，是否插入objNew,true为插入，默认是false，不插入。
	 * @param atom  原子操作，比如：$set  用来指定一个键并更新键值，若键不存在并创建。 $inc可以对文档的某个值为数字型（只能为满足要求的数字）的键进行增减的操作。详情查看 http://www.runoob.com/mongodb/mongodb-atomic-operations.html
	 */
	public function update($collection,$data,$where,$atom='$set',$multi=false,$upsert=false){
		try{
		    self::$collection->update(
		        $where,
		        [$atom => $data],
		        ['multi' => $multi, 'upsert' => $upsert]
		        );
		    
		    $result = $this->db->executeBulkWrite(self::$database.'.'.$collection, self::$collection, self::$writeConcern);
			return $result;
		}catch(\MongoCursorException $e){
			echo $e->getMessage();
			return false;
		}
	}
	/**
	 * 删除数据
	 * @param  $limit limit 为 1 时，删除第一条匹配数据 为 0 时，删除所有匹配数据
	 */
	public function delete($collection,$where,$limit=1)
	{
	    try{
	        self::$collection->delete($where, ['limit' => $limit]);
	        
	        $result = $this->db->executeBulkWrite(self::$database.'.'.$collection, self::$collection, self::$writeConcern);
	        return $result;
	    }catch(\MongoCursorException $e){
	        echo $e->getMessage();
	        exit;
	    }
	}
	/**
	 * 查询数据
	 * @param projection  查询是需要返回的键 ['user'=>1]  指定返回user   ['user'=>0] 指定不返回user
	 * 
	 * 返回值  _id 需主动注定 ['_id'=>0] 才不会返回
	 * ['_id'=>new \MongoDB\BSON\ObjectId($param['id'])]
	 */
	public function select($collection,$where=[],$projection=[],$options=[],$aggregate=[])
	{
	    try{
	        if($projection || $options || $aggregate){
    	        if($projection){
        	        $projection = ['projection'=>$projection];
    	        }
                if($options){
                    $projection = array_merge($projection,$options);
                }
                if($aggregate){
                    $projection['aggregate'] = $aggregate;
                }
            	$query = new \MongoDB\Driver\Query($where, $projection);
    	    }else{
                $query = new \MongoDB\Driver\Query($where);
    	    }
    	    $cursor = $this->db->executeQuery(self::$database.'.'.$collection, $query);

    	    return $cursor;
	    }catch(\MongoCursorException $e){
	        echo $e->getMessage();
	        exit;
	    }
	    
	}
	
	/**
	 * @return boolean
	 */
	public function is_supported()
	{
		return extension_loaded('mongodb');
	}

    /**
     * 释放链接
     */
    public function __destruct()
    {
//         self::$collection = '';
    }
}