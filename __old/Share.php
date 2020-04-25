<?php
declare(strict_types=1);

namespace App\Db;

use App\Helper\Validator;
use MongoDB\BSON\ObjectId;

class Share extends BaseMapObject {
  protected $_id;
	protected $imgUrl;
	protected $urlGuid;
	protected $expiry;
    
    protected $required = ['url', 'userId'];
    protected $dataTypes = [
      '_id'      => Validator::MONGOID,
      'imgUrl'   => Validator::URL,
      'urlGuid'  => Validator::TEXT,
      'expiry'   => Validator::DATE,
    ];
    

    public function __construct(
        ObjectId $id, 
        string $imgUrl, 
        string $urlGuid, 
        string $expiry
    ) {
        $this->setId($id);
        $this->setImgUrl($imgUrl);
        $this->setUrlGuid($urlGuid);
        $this->setExpiry($expiry);
    }


  public function getId() {
		return $this->_id;
	}
  public function setId($id) {
      $this->_id = $id;
  }

  
  public function getImgUrl(): ?string {
		return $this->imgUrl;
	}
	public function setImgUrl($email) {
		$this->imgUrl = $imgUrl;
  }
    
  
  public function getUrlGuid(): ?string {
		return $this->urlGuid;
	}
	public function setUrlGuid($urlGuid) {
		$this->urlGuid = $urlGuid;
	}

    
  public function getExpiry(): ?string {
		return $this->expiry;
	}
	public function setExpiry($expiry) {
		$this->expiry = $expiry;
	}
}