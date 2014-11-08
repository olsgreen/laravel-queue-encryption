<?php namespace Olsgreen\QueueEncryption\Connectors;

use Illuminate\Queue\Connectors\ConnectorInterface;
use Olsgreen\QueueEncryption\EncryptedSyncQueue;

class EncryptedSyncConnector implements ConnectorInterface {

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		$secret = isset($config['secret']) ? $config['secret'] : '';
		return new EncryptedSyncQueue($secret);
	}

}
