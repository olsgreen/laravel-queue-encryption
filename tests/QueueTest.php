<?php

class QueueTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		Queue::push('QueueTestWorker', array('foo' => 'bar'));
	}

}

class QueueTestWorker extends TestCase {

	public function fire($job, $data)
	{
		$this->assertTrue(is_array($data));

		$keys = array_keys($data);

		$this->assertEquals('foo', $keys[0]);
		$this->assertEquals('bar', $data['foo']);
	}

}
