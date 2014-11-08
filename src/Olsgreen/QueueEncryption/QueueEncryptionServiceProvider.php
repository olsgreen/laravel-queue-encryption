<?php namespace Olsgreen\QueueEncryption;

use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Queue\QueueManager;

class QueueEncryptionServiceProvider extends QueueServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared("queue", function($app)
		{
		  $manager = new QueueManager($app);
		  $this->registerConnectors($manager);
		  return $manager;
		});
	}

	/**
	 * Register the connectors on the queue manager.
	 *
	 * @param  \Illuminate\Queue\QueueManager  $manager
	 * @return void
	 */
	public function registerConnectors($manager)
	{
		foreach (array('Sync', 'Beanstalkd', 'Redis', 'Sqs', 'Iron', 'EncryptedSync') as $connector)
		{
			$this->{"register{$connector}Connector"}($manager);
		}
	}

	/**
	 * Register the Encrypted Sync queue connector.
	 *
	 * @param  \Illuminate\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerEncryptedSyncConnector($manager)
	{
		$manager->addConnector('encryptedsync', function()
		{
			return new Connectors\EncryptedSyncConnector;
		});
	}

}
