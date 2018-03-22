<?php
/**
 * ForumHalResponse
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * discussion
 *
 * No descripton provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 0.1.0-SNAPSHOT
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Discussion\Models;

use \ArrayAccess;

/**
 * ForumHalResponse Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ForumHalResponse implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'ForumHalResponse';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'name' => 'string',
        'id' => 'int',
        'creator_id' => 'int',
        'thread_count' => 'int',
        'post_count' => 'int',
        'parent_id' => 'int',
        'display_order' => 'int',
        'allows_threads' => 'bool',
        'description' => 'string',
        'creation_date' => '\Swagger\Client\Discussion\Models\Instant',
        'modification_date' => '\Swagger\Client\Discussion\Models\Instant',
        'is_viewable' => 'bool',
        'is_editable' => 'bool',
        'is_deleted' => 'bool',
        'site_id' => 'int',
        'image_url' => 'string',
        '_links' => '\Swagger\Client\Discussion\Models\HalLinks',
        'requester_id' => 'string',
        '_embedded' => '\Swagger\Client\Discussion\Models\HalForumEmbedded'
    );

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = array(
        'name' => 'name',
        'id' => 'id',
        'creator_id' => 'creatorId',
        'thread_count' => 'threadCount',
        'post_count' => 'postCount',
        'parent_id' => 'parentId',
        'display_order' => 'displayOrder',
        'allows_threads' => 'allowsThreads',
        'description' => 'description',
        'creation_date' => 'creationDate',
        'modification_date' => 'modificationDate',
        'is_viewable' => 'isViewable',
        'is_editable' => 'isEditable',
        'is_deleted' => 'isDeleted',
        'site_id' => 'siteId',
        'image_url' => 'imageUrl',
        '_links' => '_links',
        'requester_id' => 'requesterId',
        '_embedded' => '_embedded'
    );

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = array(
        'name' => 'setName',
        'id' => 'setId',
        'creator_id' => 'setCreatorId',
        'thread_count' => 'setThreadCount',
        'post_count' => 'setPostCount',
        'parent_id' => 'setParentId',
        'display_order' => 'setDisplayOrder',
        'allows_threads' => 'setAllowsThreads',
        'description' => 'setDescription',
        'creation_date' => 'setCreationDate',
        'modification_date' => 'setModificationDate',
        'is_viewable' => 'setIsViewable',
        'is_editable' => 'setIsEditable',
        'is_deleted' => 'setIsDeleted',
        'site_id' => 'setSiteId',
        'image_url' => 'setImageUrl',
        '_links' => 'setLinks',
        'requester_id' => 'setRequesterId',
        '_embedded' => 'setEmbedded'
    );

    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = array(
        'name' => 'getName',
        'id' => 'getId',
        'creator_id' => 'getCreatorId',
        'thread_count' => 'getThreadCount',
        'post_count' => 'getPostCount',
        'parent_id' => 'getParentId',
        'display_order' => 'getDisplayOrder',
        'allows_threads' => 'getAllowsThreads',
        'description' => 'getDescription',
        'creation_date' => 'getCreationDate',
        'modification_date' => 'getModificationDate',
        'is_viewable' => 'getIsViewable',
        'is_editable' => 'getIsEditable',
        'is_deleted' => 'getIsDeleted',
        'site_id' => 'getSiteId',
        'image_url' => 'getImageUrl',
        '_links' => 'getLinks',
        'requester_id' => 'getRequesterId',
        '_embedded' => 'getEmbedded'
    );

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['creator_id'] = isset($data['creator_id']) ? $data['creator_id'] : null;
        $this->container['thread_count'] = isset($data['thread_count']) ? $data['thread_count'] : null;
        $this->container['post_count'] = isset($data['post_count']) ? $data['post_count'] : null;
        $this->container['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : null;
        $this->container['display_order'] = isset($data['display_order']) ? $data['display_order'] : null;
        $this->container['allows_threads'] = isset($data['allows_threads']) ? $data['allows_threads'] : false;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['creation_date'] = isset($data['creation_date']) ? $data['creation_date'] : null;
        $this->container['modification_date'] = isset($data['modification_date']) ? $data['modification_date'] : null;
        $this->container['is_viewable'] = isset($data['is_viewable']) ? $data['is_viewable'] : false;
        $this->container['is_editable'] = isset($data['is_editable']) ? $data['is_editable'] : false;
        $this->container['is_deleted'] = isset($data['is_deleted']) ? $data['is_deleted'] : false;
        $this->container['site_id'] = isset($data['site_id']) ? $data['site_id'] : null;
        $this->container['image_url'] = isset($data['image_url']) ? $data['image_url'] : null;
        $this->container['_links'] = isset($data['_links']) ? $data['_links'] : null;
        $this->container['requester_id'] = isset($data['requester_id']) ? $data['requester_id'] : null;
        $this->container['_embedded'] = isset($data['_embedded']) ? $data['_embedded'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = array();
        if ($this->container['_links'] === null) {
            $invalid_properties[] = "'_links' can't be null";
        }
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        if ($this->container['_links'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets id
     * @return int
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets creator_id
     * @return int
     */
    public function getCreatorId()
    {
        return $this->container['creator_id'];
    }

    /**
     * Sets creator_id
     * @param int $creator_id
     * @return $this
     */
    public function setCreatorId($creator_id)
    {
        $this->container['creator_id'] = $creator_id;

        return $this;
    }

    /**
     * Gets thread_count
     * @return int
     */
    public function getThreadCount()
    {
        return $this->container['thread_count'];
    }

    /**
     * Sets thread_count
     * @param int $thread_count
     * @return $this
     */
    public function setThreadCount($thread_count)
    {
        $this->container['thread_count'] = $thread_count;

        return $this;
    }

    /**
     * Gets post_count
     * @return int
     */
    public function getPostCount()
    {
        return $this->container['post_count'];
    }

    /**
     * Sets post_count
     * @param int $post_count
     * @return $this
     */
    public function setPostCount($post_count)
    {
        $this->container['post_count'] = $post_count;

        return $this;
    }

    /**
     * Gets parent_id
     * @return int
     */
    public function getParentId()
    {
        return $this->container['parent_id'];
    }

    /**
     * Sets parent_id
     * @param int $parent_id
     * @return $this
     */
    public function setParentId($parent_id)
    {
        $this->container['parent_id'] = $parent_id;

        return $this;
    }

    /**
     * Gets display_order
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->container['display_order'];
    }

    /**
     * Sets display_order
     * @param int $display_order
     * @return $this
     */
    public function setDisplayOrder($display_order)
    {
        $this->container['display_order'] = $display_order;

        return $this;
    }

    /**
     * Gets allows_threads
     * @return bool
     */
    public function getAllowsThreads()
    {
        return $this->container['allows_threads'];
    }

    /**
     * Sets allows_threads
     * @param bool $allows_threads
     * @return $this
     */
    public function setAllowsThreads($allows_threads)
    {
        $this->container['allows_threads'] = $allows_threads;

        return $this;
    }

    /**
     * Gets description
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets creation_date
     * @return \Swagger\Client\Discussion\Models\Instant
     */
    public function getCreationDate()
    {
        return $this->container['creation_date'];
    }

    /**
     * Sets creation_date
     * @param \Swagger\Client\Discussion\Models\Instant $creation_date
     * @return $this
     */
    public function setCreationDate($creation_date)
    {
        $this->container['creation_date'] = $creation_date;

        return $this;
    }

    /**
     * Gets modification_date
     * @return \Swagger\Client\Discussion\Models\Instant
     */
    public function getModificationDate()
    {
        return $this->container['modification_date'];
    }

    /**
     * Sets modification_date
     * @param \Swagger\Client\Discussion\Models\Instant $modification_date
     * @return $this
     */
    public function setModificationDate($modification_date)
    {
        $this->container['modification_date'] = $modification_date;

        return $this;
    }

    /**
     * Gets is_viewable
     * @return bool
     */
    public function getIsViewable()
    {
        return $this->container['is_viewable'];
    }

    /**
     * Sets is_viewable
     * @param bool $is_viewable
     * @return $this
     */
    public function setIsViewable($is_viewable)
    {
        $this->container['is_viewable'] = $is_viewable;

        return $this;
    }

    /**
     * Gets is_editable
     * @return bool
     */
    public function getIsEditable()
    {
        return $this->container['is_editable'];
    }

    /**
     * Sets is_editable
     * @param bool $is_editable
     * @return $this
     */
    public function setIsEditable($is_editable)
    {
        $this->container['is_editable'] = $is_editable;

        return $this;
    }

    /**
     * Gets is_deleted
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->container['is_deleted'];
    }

    /**
     * Sets is_deleted
     * @param bool $is_deleted
     * @return $this
     */
    public function setIsDeleted($is_deleted)
    {
        $this->container['is_deleted'] = $is_deleted;

        return $this;
    }

    /**
     * Gets site_id
     * @return int
     */
    public function getSiteId()
    {
        return $this->container['site_id'];
    }

    /**
     * Sets site_id
     * @param int $site_id
     * @return $this
     */
    public function setSiteId($site_id)
    {
        $this->container['site_id'] = $site_id;

        return $this;
    }

    /**
     * Gets image_url
     * @return string
     */
    public function getImageUrl()
    {
        return $this->container['image_url'];
    }

    /**
     * Sets image_url
     * @param string $image_url
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        $this->container['image_url'] = $image_url;

        return $this;
    }

    /**
     * Gets _links
     * @return \Swagger\Client\Discussion\Models\HalLinks
     */
    public function getLinks()
    {
        return $this->container['_links'];
    }

    /**
     * Sets _links
     * @param \Swagger\Client\Discussion\Models\HalLinks $_links
     * @return $this
     */
    public function setLinks($_links)
    {
        $this->container['_links'] = $_links;

        return $this;
    }

    /**
     * Gets requester_id
     * @return string
     */
    public function getRequesterId()
    {
        return $this->container['requester_id'];
    }

    /**
     * Sets requester_id
     * @param string $requester_id
     * @return $this
     */
    public function setRequesterId($requester_id)
    {
        $this->container['requester_id'] = $requester_id;

        return $this;
    }

    /**
     * Gets _embedded
     * @return \Swagger\Client\Discussion\Models\HalForumEmbedded
     */
    public function getEmbedded()
    {
        return $this->container['_embedded'];
    }

    /**
     * Sets _embedded
     * @param \Swagger\Client\Discussion\Models\HalForumEmbedded $_embedded
     * @return $this
     */
    public function setEmbedded($_embedded)
    {
        $this->container['_embedded'] = $_embedded;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this));
    }
}


