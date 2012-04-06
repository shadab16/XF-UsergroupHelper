<?php

/**
 * Event listener for adding a custom template helper
 *
 * @author Shadab
 * @package GeekPoint_UsergroupHelper
 */
class GeekPoint_UsergroupHelper_EventListener
{
	/**
	 * Listen to the "init_dependencies" event
	 *
	 * @param XenForo_Dependencies_Abstract $dependencies
	 * @param array $data
	 */
	public static function listen(XenForo_Dependencies_Abstract $dependencies, array $data)
	{
		GeekPoint_UsergroupHelper_Core::addHelperCallbacks();
	}
}
