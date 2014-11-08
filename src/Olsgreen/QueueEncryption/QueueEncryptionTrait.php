<?php namespace Olsgreen\QueueEncryption;

use Crypt;
use Config;

trait QueueEncryptionTrait {

	protected $secret;

	public function __construct($secret = null)
	{
		$this->secret = $secret;
	}

	protected function temporarySecret($callback)
	{
		if ($this->secret) {
			Crypt::setKey($this->secret);
		}

		$r = $callback();

		if ($this->secret) {
			Crypt::setKey(Config::get('app.key'));
		} 

		return $r;
	}

	public function encrypt($data)
	{
		return $this->temporarySecret(function() use ($data) {
			return Crypt::encrypt(json_encode($data));
		});
	}

	public function decrypt($data)
	{
		return $this->temporarySecret(function() use ($data) {
			return Crypt::decrypt($data);
		});
	}

}