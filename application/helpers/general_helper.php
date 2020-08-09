<?php

function pre($data, $stop = 0) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if($stop > 0)
        die();
}

function select_columns($fields) {
    $select_string = '';
    if(is_array($fields) && ! empty($fields)) {
        foreach($fields AS $k => $colum) {
            if(strlen($select_string)) {
                $select_string .= ', '.$k. ' AS '.$colum;
            } else {
                $select_string .= $k. ' AS '.$colum;
            }
        }
    }
    return $select_string;
}

function fields_relation($fields, $data)
{
    $data_final = array();
    if(! empty($fields) && ! empty($data))
    {
        $filter = array_intersect_key($data, $fields);
        if( ! empty($filter))
        {
            foreach($fields AS $key => $field) {
                if(isset($filter[ $key ]))
                    $data_final[ $field ] = $filter[ $key ];
            }
        }
    }
    return $data_final;
}
