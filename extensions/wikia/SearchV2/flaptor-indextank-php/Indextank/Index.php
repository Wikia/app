<?php
/**
 * Author:: Gilles Devaux (<gilles.devaux@gmail.com>)
 * Copyright:: Copyright (c) 2011 Formspring.me
 * License:: Apache License, Version 2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * Converts an array of 2 elements (which can be NULL) to a colon-separated string containing those elements.
 * NULL elements are replaced by '*'
 *
 * Examples:
 *     indextank_map_range(array(2,4)) => "2:4";
 *     indextank_map_range(array(NULL,3)) => "*:3";
 *     indextank_map_range(array(5,NULL)) => "5:*";
 *     indextank_map_range(array(NULL,NULL)) => "*:*";
 *
 *
 * @param val: an array of 2 elements.
 * @return string
 */
function indextank_map_range($val) {
    return sprintf("%s:%s", ($val[0] == NULL ? "*" : $val[0]), ($val[1] == NULL ? "*" : $val[1]));
}

class Indextank_Index {

    /*
    * Client for a specific index.
    * It allows to inspect the status of the index.
    * It also provides methods for indexing and searching said index.
    */

    private $api = NULL;
    private $index_url = NULL;
    private $metadata = NULL;


    /**
     * You should not call this directly, but though Api#get_index
     * @param \Indextank_Api $api
     * @param  $index_name
     * @param null $metadata
     */
    public function __construct(Indextank_Api $api, $index_name, $metadata = NULL) {
        $this->api = $api;
        $this->index_url = $api->index_url(str_replace('/', '', $index_name));
        $this->metadata = $metadata;
    }

    public function exists() {
        /*
         * Returns whether an index for the name of this instance
         * exists, if it doesn't it can be created by calling
         * create_index()
         */
        try {
            $this->refresh_metadata();
            return true;
        } catch (Indextank_Exception_HttpException $e) {
            if ($e->getCode() == 404) {
                return false;
            } else {
                throw $e;
            }
        }
    }

    public function has_started() {
        /*
         * Returns whether this index is responsive. Newly created
         * indexes can take a little while to get started.
         * If this method returns False most methods in this class
         * will raise an Indextank_Exception_HttpException with a status of 503.
         */
        $this->refresh_metadata();
        return $this->metadata->{'started'};
    }

    public function get_status() {
        $this->refresh_metadata();
        return $this->metadata->{'status'};
    }

    public function get_code() {
        $this->refresh_metadata();
        return $this->metadata->{'code'};
    }

    public function get_size() {
        $this->refresh_metadata();
        return $this->metadata->{'size'};
    }

    public function get_creation_time() {
        $this->refresh_metadata();
        return $this->metadata->{'creation_time'};
    }

    public function is_public_search_enabled() {
        $this->refresh_metadata();
        return $this->metadata->{'public_search'};
    }


    public function create_index( $options = array()) {
        /*
         * Creates this index.
         * If it already existed a IndexAlreadyExists exception is raised.
         * If the account has reached the limit a TooManyIndexes exception is raised
         */
        try {
            if ( $this->exists() ) { 
                throw new Indextank_Exception_IndexAlreadyExists('An index for the given name already exists');
            }
            $res = $this->api->api_call('PUT', $this->index_url, $options);
            return $res->status;
        } catch (Indextank_Exception_HttpException $e) {
            if ($e->getCode() == 409) {
                throw new Indextank_Exception_TooManyIndexes($e->getMessage());
            }
            throw $e;
        }
    }


    public function update_index($options) {
        /*
         * Update this index.
         * If it doesn't exist a IndexDoesNotExist exception is raised.
         */
        if ( ! $this->exists() ){
            throw new Indextank_Exception_IndexDoesNotExist('An index for the given name doesn\'t exist');
        }
        
        $res = $this->api->api_call('PUT', $this->index_url, $options);
        return $res->status;
    }


    public function delete_index() {
        $res = $this->api->api_call('DELETE', $this->index_url);
        return $res->status;
    }

    public function add_document($docid, $fields, $variables = NULL, $categories = NULL) {
        /*
         * Indexes a document for the given docid and fields.
         * Arguments:
         *     docid: unique document identifier. A String no longer than 1024 bytes. Can not be NULL
         *     fields: map with the document fields. field names and values MUST be UTF-8 encoded.
         *     variables (optional): map integer -> float with values for variables that can
         *                           later be used in scoring functions during searches.
         */
        $res = $this->api->api_call('PUT', $this->docs_url(), $this->as_document($docid, $fields, $variables, $categories));
        return $res->status;
    }


    public function add_documents($documents = array()) {
        /*
         * Indexes an array of documents. Each element (document) on the array needs to be an
         * array, with 'docid', 'fields' and optionally 'variables' keys and 'categories'.
         * The semantic is the same as IndexClient->add_document();
         * Arguments:
         *     documents: an array of arrays, each representing a document
         */
        $data = array();
        foreach ($documents as $i => $doc_data) {
            try {
                // make sure docid is set
                if (!array_key_exists("docid", $doc_data)) {
                    throw new InvalidArgumentException("document $i lacks 'docid'");
                }
                $docid = $doc_data['docid'];

                // make sure fields is set
                if (!array_key_exists("fields", $doc_data)) {
                    throw new InvalidArgumentException("document $i lacks 'fields'");
                }
                $fields = $doc_data['fields'];

                // set $variables
                if (!array_key_exists("variables", $doc_data)) {
                    $variables = NULL;
                } else {
                    $variables = $doc_data['variables'];
                }

                // set $variables
                if (!array_key_exists("categories", $doc_data)) {
                    $categories = NULL;
                } else {
                    $categories = $doc_data['categories'];
                }

                $data[] = $this->as_document($docid, $fields, $variables, $categories);
            } catch (InvalidArgumentException $iae) {
                throw new InvalidArgumentException("while processing document $i: " . $iae->getMessage());
            }
        }

        $res = $this->api->api_call('PUT', $this->docs_url(), $data);
        return json_decode($res->response);
    }


    public function delete_document($docid) {
        /*
         * Deletes the given docid from the index if it existed. otherwise, does nothing.
         * Arguments:
         *     docid: unique document identifier
         */
        $res = $this->api->api_call('DELETE', $this->docs_url(), array("docid" => $docid));
        return $res->status;
    }

    public function delete_documents($docids) {
        /*
         * Deletes the given docids from the index if they existed. otherwise, does nothing.
         * Arguments:
         *     docids: unique document identifiers
         */
        $data = array("docid" => $docids);
        $res = $this->api->api_call('DELETE', $this->docs_url(), $data);
        return json_decode($res->response);
    }

    /*
     * Performs a delete on the results of a search.
     * See 'search' for parameter explanation.
     */
    public function delete_by_search($query, $start=NULL, $scoring_function=NULL, $category_filters=NULL, $variables=NULL, $docvar_filters=NULL, $function_filters=NULL) {

        $params = $this->as_search_param( $query, $start, NULL, NULL, NULL, NULL, $category_filters, $variables, $docvar_filters, $function_filters);
        
        try {
            $res = $this->api->api_call('DELETE', $this->search_url(), $params);
            return json_decode($res->response);
        } catch (HttpException $e) {
            if ($e->getCode() == 400) {
                throw new InvalidQuery($e->getMessage());
            }
            throw $e;
        }
    }


    public function update_variables($docid, $variables) {
        /*
         * Updates the variables of the document for the given docid.
         * Arguments:
         *     docid: unique document identifier
         *     variables: map integer -> float with values for variables that can
         *                later be used in scoring functions during searches.
         */
        $res = $this->api->api_call('PUT', $this->variables_url(), array("docid" => $docid, "variables" => $this->convert_to_map($variables)));
        return $res->status;
    }

    public function update_categories($docid, $categories) {
        /*
         * Updates the category values of the document for the given docid.
         * Arguments:
         *     docid: unique document identifier
         *     categories: map string -> string where each key is a category name pointing to its value
         */
        $res = $this->api->api_call('PUT', $this->categories_url(), array("docid" => $docid, "categories" => $categories));
        return $res->status;
    }

    public function promote($docid, $query) {
        /*
         * Makes the given docid the top result of the given query.
         * Arguments:
         *     docid: unique document identifier
         *     query: the query for which to promote the document
         */
        $res = $this->api->api_call('PUT', $this->promote_url(), array("docid" => $docid, "query" => $query));
        return $res->status;
    }

    public function add_function($function_index, $definition) {
        try {
            $res = $this->api->api_call('PUT', $this->function_url($function_index), array("definition" => $definition));
            return $res->status;
        } catch (Indextank_Exception_HttpException $e) {
            if ($e->getCode() == 400) {
                throw new Indextank_Exception_InvalidDefinition($e->getMessage());
            }
            throw $e;
        }
    }

    public function delete_function($function_index) {
        $res = $this->api->api_call('DELETE', $this->function_url($function_index));
        return $res->status;
    }

    public function list_functions() {
        $res = $this->api->api_call('GET', $this->functions_url());
        return json_decode($res->response);
    }


    /*
     * Performs a search.
     *
     * @param variables: An array with 'query variables'. Example: array( 0 => 3, 1 => 34);
     * @param docvar_filters: An array with filters for document variables.
     *     Example: array(0 => array(array(1,4), array(6, 9), array(16,NULL)))
     *     Document variable 0 should be between 1 and 4 OR 6 and 9 OR greater than 16
     * @param function_filters: An array with filters for function scores.
     *     Example: array(2 => array(array(2,6), array(7, 11), array(15,NULL)))
     *     Scoring function 2 must return a value between 2 and 6 OR 7 and 11 OR greater than 15 for documents matching this query.
     *
     */
    public function search($query, $start = NULL, $len = NULL, $scoring_function = NULL, $snippet_fields = NULL, $fetch_fields = NULL, $category_filters = NULL, $variables = NULL, $docvar_filters = NULL, $function_filters = NULL) {

        $params = $this->as_search_param( $query, $start, $len, $scoring_function, $snippet_fields, $fetch_fields, $category_filters, $variables, $docvar_filters, $function_filters);

        try {
            $res = $this->api->api_call('GET', $this->search_url(), $params);
            return json_decode($res->response);
        } catch (Indextank_Exception_HttpException $e) {
            if ($e->getCode() == 400) {
                throw new Indextank_Exception_InvalidQuery($e->getMessage());
            }
            throw $e;
        }
    }


    private function get_metadata() {
        if ($this->metadata == NULL) {
            return $this->refresh_metadata();
        }
        return $this->metadata;
    }

    private function refresh_metadata() {
        $res = $this->api->api_call('GET', $this->index_url, array());
        $this->metadata = json_decode($res->response);
        return $this->metadata;
    }

    /*
     * Creates a 'document', useful for IndexClient->add_document and IndexClient->add_documents
     */
    private function as_document($docid, $fields, $variables = NULL, $categories = NULL) {
        if (NULL == $docid) throw new InvalidArgumentException("\$docid can't be NULL");
        if (mb_strlen($docid, '8bit') > 1024) throw new InvalidArgumentException("\$docid can't be longer than 1024 bytes");
        $data = array("docid" => $docid, "fields" => $fields);
        if ($variables != NULL) {
            $data["variables"] = $this->convert_to_map($variables);
        }

        if ($categories != NULL) {
            $data["categories"] = $categories;
        }
        return $data;
    }




    private function as_search_param( $query, $start = NULL, $len = NULL, $scoring_function = NULL, $snippet_fields = NULL, $fetch_fields = NULL, $category_filters = NULL, $variables = NULL, $docvar_filters = NULL, $function_filters = NULL) {

        $params = array("q" => $query);
        if ($start != NULL) {
            $params["start"] = $start;
        }
        if ($len != NULL) {
            $params["len"] = $len;
        }
        if ($scoring_function != NULL) {
            $params["function"] = (string)$scoring_function;
        }
        if ($snippet_fields != NULL) {
            $params["snippet"] = $snippet_fields;
        }
        if ($fetch_fields != NULL) {
            $params["fetch"] = $fetch_fields;
        }
        if ($category_filters != NULL) {
            $params["category_filters"] = json_encode($category_filters);
        }
        if ($variables) {
            foreach ($variables as $k => $v)
            {
                $params["var" . strval($k)] = $v;
            }
        }

        if ($docvar_filters) {
            // $docvar_filters is something like
            // { 3 => [ (1, 3), (5, NULL) ]} to filter_docvar3 => 1:3,5:*
            foreach ($docvar_filters as $k => $v) {
                $params["filter_docvar" . strval($k)] = implode(array_map('indextank_map_range', $v), ",");
            }
        }

        if ($function_filters) {
            // $function_filters is something like
            // { 2 => [ (1, 4), (7, NULL) ]} to filter_function2 => 1:4,7:*
            foreach ($function_filters as $k => $v) {
                $params["filter_function" . strval($k)] = implode(array_map('indextank_map_range', $v), ",");
            }
        }
       

        return $params;
    }


    private function docs_url() {
        return $this->index_url . "/docs";
    }

    private function variables_url() {
        return $this->index_url . "/docs/variables";
    }

    private function categories_url() {
        return $this->index_url . "/docs/categories";
    }

    private function promote_url() {
        return $this->index_url . "/promote";
    }

    private function search_url() {
        return $this->index_url . "/search";
    }

    private function functions_url() {
        return $this->index_url . "/functions";
    }

    private function function_url($n) {
        return $this->index_url . "/functions/" . $n;
    }

    private function convert_to_map($array_object) {
        $result = new stdClass();

        for ($i = 0; $i < sizeof($array_object); ++$i) {
            $result->{$i} = $array_object[$i];
        }

        return $result;
    }

}
