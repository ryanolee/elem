elem_abs
===============






* Class name: elem_abs
* Namespace: 
* This is an **abstract** class
* Parent class: [elem](elem.md)





Properties
----------


### $included

    private mixed $included = array("jquerey" => false, "cookie" => false, "lazy_load" => false)





* Visibility: **private**
* This property is **static**.


### $u_id

    public mixed $u_id





* Visibility: **public**
* This property is **static**.


### $type

    public string $type

The type of HTML tag.



* Visibility: **public**
* This property is defined by [elem](elem.md)


### $attributes

    public array $attributes

an accociative array of "attributes"(keys) vand values(as literal values).



* Visibility: **public**
* This property is defined by [elem](elem.md)


### $content

    public array<mixed,mixed> $content

all content in an array that consists of strings and other elem object instances.



* Visibility: **public**
* This property is defined by [elem](elem.md)


### $self_closing

    public boolean $self_closing

wether the tag should be self closing or not.



* Visibility: **public**
* This property is defined by [elem](elem.md)


### $master

    public \elem|string $master

The element the element in question is stored within.



* Visibility: **public**
* This property is defined by [elem](elem.md)


Methods
-------


### add_script

    \elem elem_abs::add_script(string $data)





* Visibility: **public**


#### Arguments
* $data **string** - &lt;p&gt;Can be a url or raw javascript. will be inserted into script element&lt;/p&gt;



### add_css

    \elem elem_abs::add_css(string $data)





* Visibility: **public**


#### Arguments
* $data **string** - &lt;p&gt;Can be a url or raw css. will be inserted into script element&lt;/p&gt;



### add_form

    \elem elem_abs::add_form(string $action, array $field, string $id, string $method, string $ajax_eval, $encrypt_mode, string $ajax_handler)





* Visibility: **public**


#### Arguments
* $action **string** - &lt;p&gt;How the action tag will be defined in the form.&lt;/p&gt;
* $field **array** - &lt;p&gt;A 2d array contining  arrays where each item is an indevisual type of input. Each sub array contains the text to be displayed with the input type&lt;/p&gt;
* $id **string** - &lt;p&gt;Id of form.&lt;/p&gt;
* $method **string** - &lt;p&gt;POST or GET.&lt;/p&gt;
* $ajax_eval **string** - &lt;p&gt;Should ajex eval be used&lt;/p&gt;
* $encrypt_mode **mixed**
* $ajax_handler **string** - &lt;p&gt;If ajax eval is true this will signify where the ajax requests need to be sent to.&lt;/p&gt;



### add_jquerey

    null elem_abs::add_jquerey(array $extra)

Adds jquerey and various common jquerey libariries



* Visibility: **public**


#### Arguments
* $extra **array** - &lt;p&gt;Keywords for extra modules: &lt;br/&gt;
cookies:  &lt;a href=&quot;https://plugins.jquery.com/cookie/&quot;&gt;https://plugins.jquery.com/cookie/&lt;/a&gt;&lt;br/&gt;
lazy:   &lt;a href=&quot;http://www.appelsiini.net/projects/lazyload&quot;&gt;http://www.appelsiini.net/projects/lazyload&lt;/a&gt;&lt;br/&gt;
Note: All already included modules will NOT be included a second time if module was allready included with this function&lt;/p&gt;



### is_included

    mixed elem_abs::is_included($data)





* Visibility: **private**
* This method is **static**.


#### Arguments
* $data **mixed**



### __construct

    NULL elem::__construct(string $type, string $content, array $attr, boolean $unique_id, boolean $self_closing)

Constructor method for elem objects.



* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $type **string** - &lt;p&gt;dictates the type of HTML element the class will represent&lt;/p&gt;
* $content **string** - &lt;p&gt;String can be put in here to act as the inner HTML of the object&lt;/p&gt;
* $attr **array** - &lt;p&gt;Acotiative array where  attr is the key is the atrubute type and the value is the value of the atribute.&lt;/p&gt;
* $unique_id **boolean** - &lt;p&gt;wether or not a uniqe id attribute should be given to the element in question.&lt;/p&gt;
* $self_closing **boolean** - &lt;p&gt;wether the tag should be self closing or not.&lt;/p&gt;



### __toString

     elem::__toString()

Returns all HTML contained within the element(including the HTML itself)



* Visibility: **public**
* This method is defined by [elem](elem.md)




### __invoke

     elem::__invoke()

Shortcut for element selection (works similar to jquerey) will find all instances of that below it.</br> accepts forms a[b=c] or #a or .a where a b or c can be un-set or *.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### add_attr

     elem::add_attr()

Adds an atributte to an acotiative array of attributes and types.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### remove_attr

     elem::remove_attr()

Remove a dictated attribute , and its value, from the "attrubutes" accociative array



* Visibility: **public**
* This method is defined by [elem](elem.md)




### next

    \elem elem::next(string $search)

finds next instance of an elem object on the current level of the elem tree the selected.</br>Element can be subjected to a query to check for eligability for weather it should be counted as the next elem.</br>



* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $search **string** - &lt;p&gt;querey to submit&lt;/br&gt;Accepts forms a[b=c] or #a or .a where a b or c can be un-set or *. (Not required)&lt;/p&gt;



### previous

    mixed elem::previous($search)





* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $search **mixed**



### set_type

     elem::set_type()

Changes type of HTML tag.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### get_type

     elem::get_type()

Retrieves the type of the HTML tag.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### is_selfclosing

     elem::is_selfclosing()

Returns wether the element is self closing.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### add_content_string

     elem::add_content_string()

Adds content as a string to the end accociative array.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### add_content

     elem::add_content()

Adds an "elem" object to the end of the content array.<br/>Returns newly added elem object!



* Visibility: **public**
* This method is defined by [elem](elem.md)




### add_content_var

     elem::add_content_var()

Add any variable to the content of a elem object.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### clear_content

     elem::clear_content()

Resets all content to an empty array.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### get_parent

     elem::get_parent()

Pulls parent from 1 layer above



* Visibility: **public**
* This method is defined by [elem](elem.md)




### get_parents

    mixed elem::get_parents()





* Visibility: **public**
* This method is defined by [elem](elem.md)




### attr_search

    mixed elem::attr_search($attr, $val)





* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $attr **mixed**
* $val **mixed**



### overide_master

     elem::overide_master()

Forcably removes link to and parents and sets the trees base node to the element that has hed the element set to it.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### id

     elem::id()

Returns a elem object by searching all items in content recursivly (including itself).



* Visibility: **public**
* This method is defined by [elem](elem.md)




### attr_search_all

    mixed elem::attr_search_all($attr, $val, $data)





* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $attr **mixed**
* $val **mixed**
* $data **mixed**



### insert_index

     elem::insert_index()

inserts a value into the content array of the object at the specified index.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### insert_before

     elem::insert_before()

inserts a item before the object the method is invoked from



* Visibility: **public**
* This method is defined by [elem](elem.md)




### insert_after

     elem::insert_after()

inserts a item after the object the method is invoked from



* Visibility: **public**
* This method is defined by [elem](elem.md)




### get_content_index

     elem::get_content_index()

Pull an item as an index from the content of any given element.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### add_comment

    mixed elem::add_comment($text)





* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $text **mixed**



### search_all

     elem::search_all()

Searches for elems in the tree that the selected object contains.<br/> $type: the tags type <x>. <br/> $attr: The tags attribute to search for. </br> $val: the value of the attribute to search for.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### closest

    \elem|null elem::closest(string $querey)

Will iterate through levels of higherarchy and returns the first element in the higherarchy that follows a specific trait.



* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $querey **string** - &lt;p&gt;The query string to be inputted&lt;/p&gt;



### get_html

    mixed elem::get_html()





* Visibility: **public**
* This method is defined by [elem](elem.md)




### is_eligable

    boolean elem::is_eligable(string $type, string $attr, string $val)

Checks congurency of the type of elem, the attributes of the elements and the type and the value of an element.



* Visibility: **public**
* This method is defined by [elem](elem.md)


#### Arguments
* $type **string** - &lt;x&gt; (Can be &#039;*&#039; representative of all possible types of attr)
* $attr **string** - &lt;x y=z y=z y=z&gt; where attr is y.can be * representative of all possible attributes.
* $val **string** - &lt;x y=z y=z y=z&gt; where val is z (Note: will check against the selected attribute only!) Can be * for any given value.



### flatten

    \elem elem::flatten()

Flattens all objects in the data construct.



* Visibility: **public**
* This method is defined by [elem](elem.md)




### flatten_array_build

    mixed elem::flatten_array_build($first)

Handles recoursive element of elem::flatten() flatten



* Visibility: **private**
* This method is defined by [elem](elem.md)


#### Arguments
* $first **mixed**



### look_on_same_row

    \elem elem::look_on_same_row(string $direction, $search)





* Visibility: **private**
* This method is defined by [elem](elem.md)


#### Arguments
* $direction **string** - &lt;p&gt;weather too look for last or nex item;&lt;/p&gt;
* $search **mixed**



### return_all

    mixed elem::return_all()

Phrases elem object as raw HTML/XML string.



* Visibility: **private**
* This method is defined by [elem](elem.md)




### has_master

    boolean elem::has_master()

wether the elem object has a master.



* Visibility: **private**
* This method is defined by [elem](elem.md)




### get_unique_id

    mixed elem::get_unique_id()

Gets a new unique id (incroments self::$u_id)



* Visibility: **private**
* This method is **static**.
* This method is defined by [elem](elem.md)




### phrase_querey

    array elem::phrase_querey($querey)

converts querey string into array.</br>Note: "#a" = "*[id=a]" and ".a" = "*[class=a]".

Similar to jquery but not as expansive.

* Visibility: **private**
* This method is defined by [elem](elem.md)


#### Arguments
* $querey **mixed**



### 

     elem::()

elem[] attr_search(string $attr,string $val) Will search the current instance of the elem class for a attribute that is equal to the specified value.



* Visibility: **public**
* This method is defined by [elem](elem.md)



