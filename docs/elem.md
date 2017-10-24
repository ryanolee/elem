elem
===============






* Class name: elem
* Namespace: 





Properties
----------


### $u_id

    public static $u_id

A unique id that incroments each time the class is instanchiated.



* Visibility: **public**


### $type

    public string $type

The type of HTML tag.



* Visibility: **public**


### $attributes

    public array $attributes

an accociative array of "attributes"(keys) vand values(as literal values).



* Visibility: **public**


### $content

    public array<mixed,mixed> $content

all content in an array that consists of strings and other elem object instances.



* Visibility: **public**


### $self_closing

    public boolean $self_closing

wether the tag should be self closing or not.



* Visibility: **public**


### $master

    public \elem|string $master

The element the element in question is stored within.



* Visibility: **public**


Methods
-------


### __construct

    NULL elem::__construct(string $type, string $content, array $attr, boolean $unique_id, boolean $self_closing)

Constructor method for elem objects.



* Visibility: **public**


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




### __invoke

     elem::__invoke()

Shortcut for element selection (works similar to jquerey) will find all instances of that below it.</br> accepts forms a[b=c] or #a or .a where a b or c can be un-set or *.



* Visibility: **public**




### add_attr

     elem::add_attr()

Adds an atributte to an acotiative array of attributes and types.



* Visibility: **public**




### remove_attr

     elem::remove_attr()

Remove a dictated attribute , and its value, from the "attrubutes" accociative array



* Visibility: **public**




### next

    \elem elem::next(string $search)

finds next instance of an elem object on the current level of the elem tree the selected.</br>Element can be subjected to a query to check for eligability for weather it should be counted as the next elem.</br>



* Visibility: **public**


#### Arguments
* $search **string** - &lt;p&gt;querey to submit&lt;/br&gt;Accepts forms a[b=c] or #a or .a where a b or c can be un-set or *. (Not required)&lt;/p&gt;



### previous

    mixed elem::previous($search)





* Visibility: **public**


#### Arguments
* $search **mixed**



### set_type

     elem::set_type()

Changes type of HTML tag.



* Visibility: **public**




### get_type

     elem::get_type()

Retrieves the type of the HTML tag.



* Visibility: **public**




### is_selfclosing

     elem::is_selfclosing()

Returns wether the element is self closing.



* Visibility: **public**




### add_content_string

     elem::add_content_string()

Adds content as a string to the end accociative array.



* Visibility: **public**




### add_content

     elem::add_content()

Adds an "elem" object to the end of the content array.<br/>Returns newly added elem object!



* Visibility: **public**




### add_content_var

     elem::add_content_var()

Add any variable to the content of a elem object.



* Visibility: **public**




### clear_content

     elem::clear_content()

Resets all content to an empty array.



* Visibility: **public**




### get_parent

     elem::get_parent()

Pulls parent from 1 layer above



* Visibility: **public**




### get_parents

    mixed elem::get_parents()





* Visibility: **public**




### attr_search

    mixed elem::attr_search($attr, $val)





* Visibility: **public**


#### Arguments
* $attr **mixed**
* $val **mixed**



### overide_master

     elem::overide_master()

Forcably removes link to and parents and sets the trees base node to the element that has hed the element set to it.



* Visibility: **public**




### id

     elem::id()

Returns a elem object by searching all items in content recursivly (including itself).



* Visibility: **public**




### attr_search_all

    mixed elem::attr_search_all($attr, $val, $data)





* Visibility: **public**


#### Arguments
* $attr **mixed**
* $val **mixed**
* $data **mixed**



### insert_index

     elem::insert_index()

inserts a value into the content array of the object at the specified index.



* Visibility: **public**




### insert_before

     elem::insert_before()

inserts a item before the object the method is invoked from



* Visibility: **public**




### insert_after

     elem::insert_after()

inserts a item after the object the method is invoked from



* Visibility: **public**




### get_content_index

     elem::get_content_index()

Pull an item as an index from the content of any given element.



* Visibility: **public**




### add_comment

    mixed elem::add_comment($text)





* Visibility: **public**


#### Arguments
* $text **mixed**



### search_all

     elem::search_all()

Searches for elems in the tree that the selected object contains.<br/> $type: the tags type <x>. <br/> $attr: The tags attribute to search for. </br> $val: the value of the attribute to search for.



* Visibility: **public**




### closest

    \elem|null elem::closest(string $querey)

Will iterate through levels of higherarchy and returns the first element in the higherarchy that follows a specific trait.



* Visibility: **public**


#### Arguments
* $querey **string** - &lt;p&gt;The query string to be inputted&lt;/p&gt;



### get_html

    mixed elem::get_html()





* Visibility: **public**




### is_eligable

    boolean elem::is_eligable(string $type, string $attr, string $val)

Checks congurency of the type of elem, the attributes of the elements and the type and the value of an element.



* Visibility: **public**


#### Arguments
* $type **string** - &lt;x&gt; (Can be &#039;*&#039; representative of all possible types of attr)
* $attr **string** - &lt;x y=z y=z y=z&gt; where attr is y.can be * representative of all possible attributes.
* $val **string** - &lt;x y=z y=z y=z&gt; where val is z (Note: will check against the selected attribute only!) Can be * for any given value.



### flatten

    \elem elem::flatten()

Flattens all objects in the data construct.



* Visibility: **public**




### flatten_array_build

    mixed elem::flatten_array_build($first)

Handles recoursive element of elem::flatten() flatten



* Visibility: **private**


#### Arguments
* $first **mixed**



### look_on_same_row

    \elem elem::look_on_same_row(string $direction, $search)





* Visibility: **private**


#### Arguments
* $direction **string** - &lt;p&gt;weather too look for last or nex item;&lt;/p&gt;
* $search **mixed**



### return_all

    mixed elem::return_all()

Phrases elem object as raw HTML/XML string.



* Visibility: **private**




### has_master

    boolean elem::has_master()

wether the elem object has a master.



* Visibility: **private**




### get_unique_id

    mixed elem::get_unique_id()

Gets a new unique id (incroments self::$u_id)



* Visibility: **private**
* This method is **static**.




### phrase_querey

    array elem::phrase_querey($querey)

converts querey string into array.</br>Note: "#a" = "*[id=a]" and ".a" = "*[class=a]".

Similar to jquery but not as expansive.

* Visibility: **private**


#### Arguments
* $querey **mixed**



### 

     elem::()

elem[] attr_search(string $attr,string $val) Will search the current instance of the elem class for a attribute that is equal to the specified value.



* Visibility: **public**



