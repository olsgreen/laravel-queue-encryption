<?php namespace Olsgreen\QueueEncryption;

use Illuminate\Queue\SyncQueue;
use Illuminate\Queue\QueueInterface;
use Illuminate\Queue\Jobs\SyncJob;

class EncryptedSyncQueue extends SyncQueue implements QueueInterface {
	
	use QueueEncryptionTrait;

	/**
	 * Push a new job onto the queue.
	 *
	 * @param  string  $job
	 * @param  mixed   $data
	 * @param  string  $queue
	 * @return mixed
	 */
	public function push($job, $data = '', $queue = null)
	{
		$enc_data = $this->encrypt($data);
		$this->resolveJob($job, $enc_data)->fire();

		return 0;
	}

	/**
	 * Push a raw payload onto the queue.
	 *
	 * @param  string  $payload
	 * @param  string  $queue
	 * @param  array   $options
	 * @return mixed
	 */
	public function pushRaw($payload, $queue = null, array $options = array())
	{
		//
	}

	/**
	 * Push a new job onto the queue after a delay.
	 *
	 * @param  \DateTime|int  $delay
	 * @param  string  $job
	 * @param  mixed   $data
	 * @param  string  $queue
	 * @return mixed
	 */
	public function later($delay, $job, $data = '', $queue = null)
	{
		return $this->push($job, $data, $queue);
	}

	/**
	 * Pop the next job off of the queue.
	 *
	 * @param  string  $queue
	 * @return \Illuminate\Queue\Jobs\Job|null
	 */
	public function pop($queue = null) {}

	/**
	 * Resolve a Sync job instance.
	 *
	 * @param  string  $job
	 * @param  string  $data
	 * @return \Illuminate\Queue\Jobs\SyncJob
	 */
	protected function resolveJob($job, $data)
	{
		var_dump($data);
		$data = $this->decrypt($data);
		return new SyncJob($this->container, $job, $data);
	}

}
