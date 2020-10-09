<?php 
/**
 * @author Ryan Lee<lrizza@rizza.net>
 * @version v0.1
 * This is a simple module set-up by Ryan to make the construction of dynamic webpages more easy in php.
 */
//namespace rizza;
function startup(){
	//error_reporting(0);
}

function print_gzipped_output() 
{ 
    $HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"]; 
    if( headers_sent() ) 
        $encoding = false; 
    else if( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ) 
        $encoding = 'x-gzip'; 
    else if( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ) 
        $encoding = 'gzip'; 
    else 
        $encoding = false; 
    
    if( $encoding ) 
    { 
        $contents = ob_get_clean(); 
        $_temp1 = strlen($contents); 
        if ($_temp1 < 2048)  
            print($contents); 
        else 
        { 
            header('Content-Encoding: '.$encoding); 
            print("\x1f\x8b\x08\x00\x00\x00\x00\x00"); 
            $contents = gzcompress($contents, 9); 
            $contents = substr($contents, 0, $_temp1); 
            print($contents); 
        } 
    } 
    else 
        ob_end_flush(); 
} 
/**
 * Can only be called once and will echo entire document.
 * @param string $data Data to echo as gzipped content
 * @return null
 */
function gzip_echo($data){
	ob_start();
	ob_implicit_flush (true);
	print (string)$data;
	print_gzipped_output();
	exit();
}

/*function save_as_html($data,$path="",$gzipped=false){
	if (!is_string($data)){
			$data=(string)$data;	
	}
	try{
		if ($gzipped){
			$path.=".gz";
			$file=gzopen($path, "w9");
			gzwrite($file, $data);
			gzclose($file);
		}
		else{
			$file=fopen($path,"w");
			fwrite($file,$data);
			fclose($file);
		}
		return true;
	}
	catch(Exception $e){
		return false;
	}
}*/

/**
 * @author RIZZA <landgraabiv@gmail.com>
 * Elem is a class for all elements within a HTML document. (intended in a tree like construct of multiple layers of elem objects) 
 * @method elem add_attr(string $type, string $content) Adds an atributte to an acotiative array of attributes and types.
 * @method elem remove_attr(string $type) Remove a dictated attribute , and its value, from the "attrubutes" accociative array
 * @method elem set_type(string $new_type) Changes type of HTML tag.
 * @method string get_type() Retrieves the type of the HTML tag.
 * @method elem add_content_string(string $item) Adds content as a string to the end accociative array.
 * @method elem add_content(string $type,string $content,string[] $attr, boolean $unique_id,boolean $self_closing) Adds an "elem" object to the end of the content array.<br/>Returns newly added elem object!
 * @method elem clear_content() Resets all content to an empty array.
 * @method elem get_parent() Pulls parent from 1 layer above
 * @method elem[] get_parents() Returns a list of higherarchical elements in increasing orders of importance
 * @method elem id(string $val) Returns a elem object by searching all items in content recursivly (including itself).
 * @method elem[] attr_search_all(string $attr, string $val, NULL $data) will ratrive all elem objects with that attribute or attribute with a specific value.
 * @method elem insert_index(integer $index, mixed $value) inserts a value into the content array of the object at the specified index.
 * @method elem insert_before(mixed $item) inserts a item before the object the method is invoked from
 * @method elem insert_after(mixed $item) inserts a item after the object the method is invoked from
 * @method elem[] attr_search(string $attr,string $val) Will search the current instance of the elem class for a attribute that is equal to the specified value.
 * @method elem_array __invoke(string $key) Shortcut for element selection (works similar to jquerey) will find all instances of that below it.</br> accepts forms a[b=c] or #a or .a where a b or c can be un-set or *.
 * @method string __toString() Returns all HTML contained within the element(including the HTML itself)
 * @method elem add_content_var(mixed $var) Add any variable to the content of a elem object.
 * @method mixed get_content_index(integer $index) Pull an item as an index from the content of any given element.
 * @method boolean is_selfclosing() Returns wether the element is self closing.
 * @method array search_all( string $type, string $attr, string $val) Searches for elems in the tree that the selected object contains.<br/> $type: the tags type <x>. <br/> $attr: The tags attribute to search for. </br> $val: the value of the attribute to search for.
 * @method elem overide_master() Forcably removes link to and parents and sets the trees base node to the element that has hed the element set to it.
 *  
 * @property static $u_id A unique id that incroments each time the class is instanchiated.
 * @property string $type The type of HTML tag. 
 * @property array $attributes an accociative array of "attributes"(keys) vand values(as literal values).
 * @property mixed[] $content all content in an array that consists of strings and other elem object instances.
 * @property boolean $self_closing wether the tag should be self closing or not.
 * @property elem|string $master The element the element in question is stored within.
 */

class elem{
	use phrase_q;
	static $u_id=0;#static id for unique assignment
	/**
	 * Constructor method for elem objects.
	 * @param string $type dictates the type of HTML element the class will represent
	 * @param string $content String can be put in here to act as the inner HTML of the object
	 * @param array $attr Acotiative array where  attr is the key is the atrubute type and the value is the value of the atribute.
	 * @param boolean $unique_id wether or not a uniqe id attribute should be given to the element in question.
	 * @param boolean $self_closing wether the tag should be self closing or not.
	 *
	 *@return NULL
	 */
	public function __construct($type="div",$content="",$attr=array(),$unique_id=False,$self_closing=false){#constructor method for any element
		$this->type=$type;#tag type
		$this->attr=$attr;# attributes for the tag
		$this->content=array((string)$content);#content (can be raw text)
		$this->self_closing=$self_closing;
		if (isset(debug_backtrace()[1]['object'])){	
			$this->master=debug_backtrace()[1]['object'];
		}
		else{
			$this->master="None";
		}
		if ($unique_id){
			$this->attr=array_merge($this->attr, array("id"=>self::get_unique_id()));
		}
	}
	/**
	 * When a elem object is treated as a string.
	 * @return string (A raw string formed of all HTML stored within the element)
	 */
	public function __toString(){
			return $this->return_all();
	}

	public function __invoke($key){#gets all instances of the elem
		//<multi id> match where there is a id the a 
		$phrased=$this->phrase_querey($key);
		$type=$phrased[0];
		$attr=$phrased[1];
		$val=$phrased[2];
		$result=$this->search_all($type,$attr,$val);
		if($result==null){
			$result=array();
		}
		return new elem_array($result);
	}
	public function add_attr($type,$content){#adds an attribute to the tag in question
		if(!isset($this->attr[$type])){
			$this->attr=array_merge($this->attr,array((string)$type=>(string)$content));
		}
		return $this;
	}
	public function remove_attr($type){#removes the attribute in question
		if(isset($this->attr[$type])){
			unset($this->attr[$type]);
			return true;
		}
		return false;
	}
	/**
	 * finds next instance of an elem object on the current level of the elem tree the selected.</br>Element can be subjected to a query to check for eligability for weather it should be counted as the next elem.</br> 
	 * @param string $search querey to submit</br>Accepts forms a[b=c] or #a or .a where a b or c can be un-set or *. (Not required)
	 * @return elem
	 */
	public function next($search=null){
		return $this->look_on_same_row("next",$search);
	}
	public function previous($search=null){
		return $this->look_on_same_row("previous",$search);
	}
	public function set_type($new_type){#changes the type of tag
		$this->type=$new_type;
		return $this;
	}
	public function get_type(){#gets tag type
		return $this->type;
	}
	public function is_selfclosing(){
		return $this->self_closing;
	}
	public function add_content_string($item){#Adds a content as a string(Terminates stack of element)
		array_push($this->content,htmlentities((string)$item));
		return $this;
	}
	public function add_content($type="div",$content="",$attr=array(),$unique_id=False,$self_closing=False){#adds a "elem" object to content.
		array_push($this->content,new elem($type,$content,$attr,$unique_id,$self_closing));	
		return $this->content[sizeof($this->content)-1];// 
	}
	public function add_content_var($var){
		array_push($this->content,$var);
		return $this;
	}
	public function clear_content(){#clears all contetnt of an element
		$this->content=array();
		return $this;
	}
	public function get_parent(){#Gets parent
		if($this->has_master()){
			return $this->master;
		}
		return $this;
	}
	public function get_parents(){#Gets list of parent at ascending levels of hierarchy. 
		return $this->master->parent_list_construct();
	}
	public function attr_search($attr,$val){# searches for attributes of things with equal values
		if(isset($this->attr[$attr])){
			if($this->attr[$attr]==$val){
				return $this;
			}
		}
		foreach($this->content as $item){
			if(isset($item->content)){
				return $item->attr_search($attr,$val);
			}
		}
		return "None";
	}
	public function overide_master(){
		$this->master="None";
		return $this;
	}
	public function id($val){
		return $this->attr_search_all("id",$val);
	}
	public function attr_search_all($attr,$val="",$data=array()){#will search all children for an items with an attribute given and it will apply a specific type is you whant all of one type
		// @TODO Core region for selecting data recoursivly (expand)
		if(isset($this->attr[$attr])&&$val!=""){
			if($this->attr[$attr]==$val){
				array_push($data,$this);
			}
		}
		if($val==""&&isset($this->attr[$attr])){
			array_push($data,$this);
		}
		//region for weather to add self or not end^^
		$local_data=$data;
		
		foreach($this->content as $item){
			if(isset($item->content)){
				$retrived_content=$item->attr_search_all($attr,$val);
				if (isset($retrived_content)){
					$local_data=array_merge($local_data,$retrived_content);
				}
			}
		}
		if (sizeof($local_data)!=0){
			return $local_data;
		}
	}
	public function insert_index($index,$item){
		if ($index<0){#is item is to be inserted befor the list
			array_merge(array($item),$this->content);
		}
		elseif ($index>sizeof($this->content)){#append item to end
			array_merge($this->content,array($item));
		}
		array_splice( $this->content, $index, 0, array($item) );#place at requested index
		return $this;
	}
	public function insert_before($item){
		if($this->has_master()){
			$this->master->insert_index(array_search($item,$this->master->content)-1,$item);
		}
		return $this;
		
	}
	public function insert_after($item){
		if($this->has_master()){
			$this->master->insert_index(array_search($item,$this->master->content)+1,$item);
		}
		return $this;
	}
	public function get_content_index($index){
		if(isset($this->content[$index])){
			return $this->content[$index];
		}
	}
	public function add_comment($text){
		array_push($this->content,new comment($text));
	}
	public function search_all($type="*",$attr="*",$val="*"){#will search all children for an items with an attribute given and it will apply a specific type is you whant all of one type
		$data=array();
		if ($this->is_eligable($type, $attr, $val)){
			array_push($data,$this);
		}
		//region for weather to add self or not end^^
		$local_data=$data;
		
		foreach($this->content as $item){
			if(isset($item->content)){
				$retrived_content=$item->search_all($type,$attr,$val);
				if (isset($retrived_content)){
					$local_data=array_merge($local_data,$retrived_content);
				}
			}
		}
		if (sizeof($local_data)!=0){
			return $local_data;
		}
	}
	/**
	 * Will iterate through levels of higherarchy and returns the first element in the higherarchy that follows a specific trait.
	 * @param string $querey The query string to be inputted
	 * @return elem|null
	 * 
	 */
	public function closest($querey){
		$querey=$this->phrase_querey($querey);
		$parents=$this->parent_list_construct();
		foreach($parents as $item){
			if($item->is_eligable($querey["type"],$querey["attr"],$querey["val"])){
				return $item;
			}
		}
		return null;
	}
	/**
	 * @returns raw HTML string of all html held within the given element.
	 */
	public function get_html(){
		return $this->return_all();
	}
	/**
	 * Checks congurency of the type of elem, the attributes of the elements and the type and the value of an element.
	 * @param string $type <x> (Can be '*' representative of all possible types of attr)
	 * @param string $attr <x y=z y=z y=z> where attr is y.can be * representative of all possible attributes.
	 * @param string $val <x y=z y=z y=z> where val is z (Note: will check against the selected attribute only!) Can be * for any given value.
	 * @return bool Wether or not the selected elem is eligable as per the given peramiters.
	 */
	public function is_eligable($type="*",$attr="*",$val="*"){
		if ($type==$this->type||$type=="*"){//Check for type congruency
			$type_check=true;
		}
		else{
			$type_check=false;
		}
		if(isset($this->attr[$attr])||$attr=="*"){//check for attrubute congruency
			$attr_check=true;
		}
		else{
			$attr_check=false;
		}
		switch($val){
			case "*":$val_check=true; break;
			default: $val_check=false; break;
		}
		if($attr=="*"&&in_array($val, $this->attr)){
			$val_check=true;
		}
		elseif(isset($this->attr[$attr])){
			if($this->attr[$attr]==$val){
				$val_check=true;
			}
		}
		if($type_check && $attr_check && $val_check){//vlaidate all 3 checks for the data to be added to subject array
			return true;
		}
		return false;
	}
	/**
	 * Flattens all objects in the data construct. 
	 * @return elem $this
	 */
	public function flatten(){
		$this->content=$this->flatten_array_build("first");
		foreach($this->content as $item){
			if(is_a($item,"elem")){
				$item->master=$this;
				$item->self_closing=true;
				$item->content=array();
			}
		}
		return $this;
	}
	/**
	 * Handles recoursive element of elem::flatten() flatten
	 */
	private function flatten_array_build($first=""){
		$to_add=array();
		if($first==""){
			array_push($to_add,$this);
		}
		foreach($this->content as $item){
			if(is_a($item,"elem")){
				$to_add=array_merge($to_add,$item->flatten_array_build());
			}
			else{
				array_push($to_add,$item);
			}
		}
		return $to_add;
	}
	/**
	 * 
	 * @param string $direction weather too look for last or nex item;
	 * @param string $querey @see elem::phrase_querey
	 * @return elem
	 */
	private function look_on_same_row($direction,$search="null"){
		if($this->parent!="None"){
			$parent_content=$this->parent->content;
			$place=array_search ($this,$parent_content);
			if ($direction=="next"){
				$data_range=array_slice($parent_content,$place+1,sizeof($parent_content));
			}
			else{//previous
				$data_range=array_slice($parent_content,0,$place-1);
			}
			foreach($data_range as $data){
				if(is_a($data,"elem")&&is_null($search)){
					return $data;
				}
				elseif(is_a($data,"elem")&&!is_null($search)){
					$search=$this->phrase_querey($search);
					if ($data->is_eligable($search[0], $search[1], $search[2])){
						return $data;
					}
				}
			}
				
		}
		return $this;
	}
	
	/**
	 *  recursive function that constructs hierarchical list of element objects.<br/> Where $x[0] is current item and $x[n] is the highest level master (where n is the last index of the array).
	 * @ignore  $item (used for recuoursion).
	 * @return array
	 */
	private function parent_list_construct($item=array()){#
		if (!is_a($this->master,"elem")){
			return $item;
		}
		array_push($item,$this->master);
		return $this->master->parent_list_construct($item);
	}
	/**
	 * Phrases elem object as raw HTML/XML string.
	 * @retun string
	 */
	private function return_all(){
		$attributes="";
		foreach($this->attr as $attr=>$val){
			$attributes.= (string)$attr."='".preg_replace("/'/si","\'",$val)."' ";
		}
		if(!$this->self_closing){
			$content="";
			foreach($this->content as $data){
				$content.=(string)$data;
			}
			return "<".$this->type." ".$attributes.">".$content."</".$this->type.">";
		}
		else{
			return "<".$this->type." ".$attributes."/>";
		}
	}
	/**
	 * wether the elem object has a master.
	 * @return boolean
	 */
	private function has_master(){
		if($this->master=="None"){
			return false;
		}
		return true;
	}
	/**
	 * Gets a new unique id (incroments self::$u_id)
	 * 
	 */
	private static function get_unique_id(){
		self::$u_id+=1;
		return (string) self::$u_id;
	}
}
trait phrase_q{
	/**
	 * converts querey string into array.</br>Note: "#a" = "*[id=a]" and ".a" = "*[class=a]".
	 * Similar to jquery but not as expansive.
	 * @param string $query (in the form "a[b=c]", "a[b]", "a", "#a" or ".a" where a b and c can equal *)
	 * @throws Exception if the query is invalid or malformed.
	 * @return array $x<br/> Where:<br/>$x[0] or $x["type"] is equal to the type as defind in query string (a).<br/>$x[1] or $x["attr"] is equal to the attribute type as defind in query string (b).<br/>$x[2] or $x["val"] is equal to the attribute value as defind in query string (c).
	 */
	private function phrase_querey($querey){
		$pattern="/((\s*((?<type>\w+)|(?<all>\*))\s*(\s*\[\s*\s*((?<attr>\w+)|(?<all_attr>\*))\s*(=\s*(?<val>(\"[^\"]*\"|\'[^\']*\'|\w+))|=\s*(?<all_val>\*))?\s*\]\s*)?)|\s*(\.(?<class>\w+)|#(?<id>\w+)\s*))/A";
		$data=preg_match_r($pattern,$querey);
		if(sizeof($data)==0){
			throw new Exception("Unable to intrperate querey string!");
			return null;
		}
		$attr=$val=$type="*";
		if (isset($data["id"])){
			$val=$data["id"];
			$attr="id";
		}
		elseif(isset($data["class"])){
			$val=$data["class"];
			$attr="class";
		}
		else{
			if(isset($data["type"])){
				if(sizeof($data["type"]!=0)){
					$type=$data["type"];
				}
			}
			if(isset($data["attr"])){
				$attr=$data["attr"];
			}
			if(isset($data["val"])){
				$val=trim($data["val"],"'\"");
			}
		}
		$phrased=array($type,$attr,$val);
		$phrased["type"]=$type;
		$phrased["attr"]=$attr;
		$phrased["val"]=$val;
		return $phrased;
	}
}
/**
 * A custom data wrapper to overide how each instance of the array is handled. 
 * @ignore This class is part of the core functioning of the elem object and will only<br/> appear by invoking the __invoke magic method on an instance of an elem object.
 * @author RIZZA <landgraabiv@gmail.com>
 * @see http://us2.php.net/manual/en/class.arrayaccess.php
 * @see http://php.net/manual/en/class.iterator.php
 * @method elem_array __call(string)
 */

class elem_array implements Iterator, ArrayAccess{
	use phrase_q;
	private $pos=0;
	private $accepted_methods=array(
			"get_type",
			"add_content",		
			"add_content_var",
			"add_content_string",
			"insert_before",
			"insert_after",
			"remove_attr",
			"add_attr",
			"add_comment"
	);
	/**
	 * A custom data wrapper to overide how each instance of the array is handled. 
	 * @param elem[] $data The list of elem objects to handle 
	 * @return $this OR elem
	 */
	public function __construct(array $data){	
		$this->data=$data;
	}
	/**
	 * 
	 * @param querey string: Must be in the form (a[b="c"]) where <br/> a is the element type.<br/>b is the attribute <c> is the attributes value
	 */
	public function __invoke($querey){//eliminates data that does no fit querey
		$querey=$this->phrase_querey($querey);
		foreach($this->$data as $elem){
			if(!$elem->is_eligable($querey[0],$querey[1],$querey[2])){
				unset($this->data[array_search($elem,$this->data)]);
				$this->data=array_values($this->values);//reset keys to acenting numbers.
			}
		}
	}
	public function __call($method,$args){
		$x=0;
		foreach ($args as $arg){
			$args[$x]=var_export($arg,true);
			$x++;
		}
		if (sizeof($args)==1){
			$str_args=$args[0];
		}
		else{
			$str_args=implode(",",$args);
		}
		if (in_array($method, $this->accepted_methods)){
			foreach ($this->data as $elem_obj){
				if (is_a($elem_obj,"elem")){
					eval("\$elem_obj->".$method."(".$str_args.");");
				}
			}
		}
		if (sizeof($this->data)==1){
			return $this->data[0];
		}
		return $this;
	}
	// Define Itorator interface
	public function next(){
		$this->pos++;
	}
	public function key(){
		return $this->pos;
	}
	public function rewind(){
		$this->pos=0;
	}
	public function current(){
		return $this->data[$this->pos];
	}
	public function valid(){
		return isset($this->data[$this->pos]);
	}
	// Define ArrayAccess interface
	public function offsetGet($offset){
		return isset($this->data[$offset]) ? $this->data[$offset] : null;
	}
	public function offsetSet($offset, $value){
		if (is_null($offset)){
			$this->data[]= $value;
		}
		else{
			$this->data[$offset]=$value;
		}
	}
	public function offsetExists($offset){
		return isset($this->data[$offset]);
	}
	public function offsetUnset($offset){
		unset($this->data[$offset]);
	}
	//All that needs to be defined has been defined.
	
	
}
abstract class elem_abs extends elem{#Abstract class for common methods across most things so common sorts of attr can be loaded
	/**
	 * @param string $data Can be a url or raw javascript. will be inserted into script element
	 * @return elem
	 */
	public function add_script($data){
		if(filter_var($data, FILTER_VALIDATE_URL)){
			$this->add_content_var(new elem("script","",array("src"=>$data,"type"=>"text/javascript")));
		}
		else{
			$this->add_content_var(new elem("script",$data,array("type"=>"text/javascript")));
		}
	}
	/**
	 * @param string $data Can be a url or raw css. will be inserted into script element
	 * @return elem
	 */
	public function add_css($data){#TODO change to css
		if(filter_var($data, FILTER_VALIDATE_URL)){
			$this->add_content_var( new elem("link","",array("href"=>$data,"rel"=>"stylesheet","type"=>"text/css")));
		}
		else{
			$this->add_content_var(new elem("style",$data));
		}
	}
	/**
	 *
	 * @param string $action How the action tag will be defined in the form.
	 * @param array $field A 2d array contining  arrays where each item is an indevisual type of input. Each sub array contains the text to be displayed with the input type
	 * @param string $id Id of form.
	 * @param string $method POST or GET.
	 * @param string $ajax_eval Should ajex eval be used
	 * @param string $encryption mode:
	 * @param string $ajax_handler If ajax eval is true this will signify where the ajax requests need to be sent to.
	 * @return elem
	 */
	public function add_form($action,$field,$id,$method="post",$ajax_eval=false,$encrypt_mode="none",$ajax_handler="./php/ajax_validate.php"){
		$form=new elem("form","",array("action"=>$action,"method"=>$method,"id"=>$id));
		$main=$form->add_content("table","",array("class"=>"form"));
		$main;
		$counter=0;
		foreach($field as $data){
			$type=$data[0];
			$text=$data[1];
			if(in_array($type,array("email","password","text"))){
				$selected=$main->add_content("tr","",array("id"=>$counter));
				$selected->add_content("td")->add_content_string($text);
				$input=$selected->add_content("td")->add_content("input","",array("type"=>$type,"id"=>"input_".(string)$counter,"name"=>"input_".(string)$counter),false,true);
				if($ajax_eval){
					$input->add_attr("ajax_validate","")->add_attr("ajax_validate_link",$ajax_handler);
					$selected->add_content("td","",array("id"=>"ajax_area_".(string)$counter,"class"=>"ajax_val"));
				};
			}
			$counter++;
		}
		$main->add_content("td")->get_parent()->add_content("td")->add_content("input","",array("type"=>"submit","value"=>"submit"),false,true)->get_parent()->add_content("input","",array("name"=>"sent_from","type"=>"hidden","value"=>htmlentities("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])),false,true);
		$this->add_content_var($form);
		if ($ajax_eval){
			$this->add_jquerey("cookie");
			if ($encrypt_mode=="none"){
				$this->add_content_var("<script type='text/javascript' src='./js/ajax_validate.js'></script>");
			}
			else{
				$this->add_content_var("<script type='text/javascript' src='./js/ajax_validate_crypt.js'></script>");
			}
			$this->add_content_var("<style type='text/css'>.ajax_val{ vertical-align: middle;}</style>");
		}
		return $this->content[sizeof($this->content)-1];
	}
	/**
	 * Adds jquerey and various common jquerey libariries
	 * @param array $extra Keywords for extra modules: <br/>
	 * cookies:  https://plugins.jquery.com/cookie/<br/>
	 * lazy:   http://www.appelsiini.net/projects/lazyload<br/>
	 * Note: All already included modules will NOT be included a second time if module was allready included with this function
	 * @return null
	 */
	public function add_jquerey($extra=array()){
		if(is_string($extra)){
			$extra=array($extra);
		}
		if(!self::is_included("jquerey")){
			$this->add_script("https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js","./js/jq.js");
		}
		self::$included["jquerey"]=true;
		$libs=array(
				"cookie"=>"https://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js",
				"lazy_load"=>"https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
		);
		foreach ($extra as $item){
			if (isset($libs[$item])){
				if(!self::is_included($item)){
					$this->add_script($libs[$item]);
					self::$included[$item]=true;
				}
			}
		}
	}
	private static $included = array("jquerey"=>false,"cookie"=>false,"lazy_load"=>false);
	private static function is_included($data){
		if(isset($included[$data])){
			return $included[$data];
		}
	}
}
class comment{
	public function __construct($comment){
		$this->comment=$comment;
		if (isset(debug_backtrace()[1]['object'])){
			$this->master=debug_backtrace()[1]['object'];
		}
		else{
			$this->master="None";
		}
	}
	public function __toString(){
		return "<!--".$this->comment."-->";
	}
	public function append($data){
		$this->comment.=(string)$data;
		return $this->master;
	}
	public function remove(){
		$master=$this->master;
		unset($this);
		return $master;
	}
}
/**
 * invokes preg_matchs and returns the $data argument;
 * @param string $pattern regex pattern
 * @param string $subject string to check regex against
 * @return array $data
 */
function preg_match_r($pattern,$subject){
	preg_match($pattern, $subject,$data);
	return $data;
}

class HTML_phrase{
	public function __construct($html=""){
		$this->html=$html;
	}
	public function set_html($html){
		$this->html=$html;
	}
	public function get_elem(){
		$data=$this->phrase($this->html);
		while(is_array($data)){
			$data=$this->phrase($data[0],$data[1],$data[2],$data[3]);
		}
		return $data;
	}
	/**
	 * Phrases a simple html string into an elem data_structure 
	 * @param string $html Raw html to be phrased
	 * @param array $stack IGNORE
	 * @param unknown $current IGNORE
	 * @param unknown $final IGNORE
	 * @return elem
	 */
	static private function phrase($html,$stack=array(),$current=null,$final=null){
		//echo var_export($stack);
		if(!is_null($final)&&sizeof($stack)==0){
			return $final;
		}
		if (is_null($current)){
			$data=preg_match_r("/\s*<!--\s*(?<meta>.*)\s*-->(?<next>.*)/Ai",$html);
			if(sizeof($data)!=0){
				$html=$data["next"];
			}
		}
		if(sizeof($stack)>=1){
			foreach(range(sizeof($stack)-1,0,-1) as $count){// do a callback to see if there are things that are unexpected :)
				$type_to_look_for_end_of=$stack[$count];
				$end_check=preg_match_r("/(?<inner_content>[^<]*)\s*<\s*\/\s*".$type_to_look_for_end_of."\s*>(?<next>.*)/siA", $html);
				if(sizeof($end_check)>=1){
					//$inner_content=preg_split("/\s*<\s*\/\s*".$type_to_look_for_end_of."\s*>/", $html,1)[0];//$end_check["inner_content"];//@TODO apply secondary callback here
					$html=$end_check["next"];
					//$current->add_content_string($inner_content);
					//go up x layer in tree and recall base val
					$current=$current->get_parents();//[$count];
					$current=$current[sizeof($current)-1-$count];
					$current->flatten();
					$stack=array_slice($stack,0,$count);//remove item from stack
					return array($html,$stack,$current,$final);
				}
			}
			$self_close_check=preg_match_r("/(?<inner_content>[^<]*)<\s*\/\s*(?<end>\w+)\s*>/A",$html);
			if(sizeof($self_close_check)>=1){
				if($stack[sizeof($stack)-2]==$self_close_check["end"]){
					$inner_content=$self_close_check["inner_content"];
					$current->add_content_string($inner_content);
					$current->self_closing=true;
					//go up 1 layer in tree and recall base
					$current=$current->get_parent();
					array_pop($stack);//remove item from stack
					return array($html,$stack,$current,$final);
				}
			}
		}
		//add check for tag stack close
		$first_match_group=preg_match_r("/(?<before>([^<]*(<!--)*)*)<\s*(?<type>\w+)\s*(?<next>.*)/siA",$html);
		$before=$first_match_group["before"];
		$type=$first_match_group["type"];
		$next=$first_match_group["next"];
		/*
		Array indexes:
		["before"]: string that appears before the '<' of a HTML tag.
		["type"]: the type of the html tag in question
		["next"]: following the type (including atributes)
		REGEX /(?<before>.+)<\s{0,}(?<type>\w+)\s+(?<next>.+)/si
		"(?<before>.*)": set index 'before' for returnd array to all string charicters that are not a "<" charicter.(can be noting)
		"<": look for opening less than symbol.
		"\s{0,}": look for any whitspace between the count of 0 and infinity
		"(?<type>\w+)" collect a string of non punctual charicters
		"\s+":expect whitespace charicters after the fact
		"(?<next>.*)" Captures everything after the type
		"/siA"  's' dot matches newline , i case insensitive,  'A' matches only at the start of string.
		See: http://www.phpliveregex.com/p/erB
		*/
		$attr_to_add=array();
		$fail_safe=0;
		while(true){//infinite loop
			$fail_safe++;
			if($fail_safe>50){
			
				throw new Exception("Failed: to phrase html (malformed attributes) NOTE ALL SELF CLOSING TAGS MUST HAVE A '/>'");
				exit();
			}
			$end_of_tag_check=preg_match_r("/\s*((?<not_self_closing>>)|(?<self_closing>(\/\s*>)))(?<next>.*)/siA",$next);
			if(sizeof($end_of_tag_check)>=1){// handle self closing if ending found
				
				$self_closing=$end_of_tag_check["self_closing"];
				$not_self_closing=$end_of_tag_check["not_self_closing"];
				if($self_closing!=""){
					$self_closing=true;
				}
				else{
	
					$self_closing=false;
				}
				$next=$end_of_tag_check["next"];
				break;
			}
	
			$attr_data=preg_match_r("/\s*(?<attr>(?:\w|-|_)+)\s*=\s*(?<val>(?:\"(?:[^\"\\]|\\.)*\"|'(?:[^'\\]|\\.)*')\s*)?(?<next>.*)/siA", $next);#/\s*(?<attr>(\w|-|_)+)\s*(=\s*(?<val>("(?:[^"\\]|\\.)*"|'(?:[^'\\]|\\.)*')\s*)?(?<next>.*)/siA
			$attr_name=$attr_data["attr"];
			$attr_val="";
			if( isset($attr_data["val"])){
				$attr_val=trim($attr_data["val"],"'\"");
			}
			$next=$attr_data["next"];
			$attr_to_add=array_merge($attr_to_add,array($attr_name=>$attr_val));
		}
		if($type==="script"||$type==="style"){
			$this->handle_extream_case($html);
		}
		if (is_null($final)){//if the final form of the tree is not set
			$final= new elem($type,"",$attr_to_add,false,$self_closing);//construct it
			$final->overide_master();
			$current=$final;//set current to it
		}
		else{
			$current=$current->add_content($type,"",$attr_to_add,false,$self_closing);//add elem obj to constructing tree and go up 1 level.
	
		}
		$current->insert_before($before);//dump before_data before it
		if($current->is_selfclosing()){
			$current=$current->get_parent();
		}
		else{
			array_push($stack,$type);//add item to the stack
		}
		return array($next,$stack,$current,$final);
	}
	
	static private function handle_extream_case_script($html,$type="script",$stack="array"){
		
	}
}

?>
