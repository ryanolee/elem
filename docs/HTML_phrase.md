HTML_phrase
===============






* Class name: HTML_phrase
* Namespace: 







Methods
-------


### __construct

    mixed HTML_phrase::__construct($html)





* Visibility: **public**


#### Arguments
* $html **mixed**



### set_html

    mixed HTML_phrase::set_html($html)





* Visibility: **public**


#### Arguments
* $html **mixed**



### get_elem

    mixed HTML_phrase::get_elem()





* Visibility: **public**




### phrase

    \elem HTML_phrase::phrase(string $html, array $stack, \unknown $current, \unknown $final)

Phrases a simple html string into an elem data_structure



* Visibility: **private**
* This method is **static**.


#### Arguments
* $html **string** - &lt;p&gt;Raw html to be phrased&lt;/p&gt;
* $stack **array** - &lt;p&gt;IGNORE&lt;/p&gt;
* $current **unknown** - &lt;p&gt;IGNORE&lt;/p&gt;
* $final **unknown** - &lt;p&gt;IGNORE&lt;/p&gt;



### handle_extream_case_script

    mixed HTML_phrase::handle_extream_case_script($html, $type, $stack)





* Visibility: **private**
* This method is **static**.


#### Arguments
* $html **mixed**
* $type **mixed**
* $stack **mixed**


