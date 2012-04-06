<?php

/**
 * Template-Helper class for checking a visitor's usergroup
 *
 * @author Shadab
 * @package GeekPoint_UsergroupHelper
 */
class GeekPoint_UsergroupHelper_Core
{
	/**
	 * Add a new helper to the XenForo_Template_Helper_Core class
	 */
	public static function addHelperCallbacks()
	{
		XenForo_Template_Helper_Core::$helperCallbacks += array(
			'checkusergroup' => array('GeekPoint_UsergroupHelper_Core', 'helperCheckUsergroup')
		);
	}

	/**
	 * Check if a visitor belongs to a usergroup
	 *
	 * This is a variadic method that accepts a $visitor array (required paramemter).
	 * The second parameter is optionally a string specifying the usergroup search-type.
	 * Options include ALL, PRIMARY, SECONDARY. If no type is specified, 'ALL' is used
	 * by default. This is followed by usergroup IDs which the visitor is being checked
	 * against. At least one usergroup ID has to be specified in the parameter list.
	 *
	 * @param array $visitor
	 * @param integer|string $userGroupType
	 * @return boolean
	 */
	public static function helperCheckUsergroup($visitor, $userGroupType)
	{
		$argc = func_num_args();
		$argv = func_get_args();

		if (!$visitor || !$userGroupType)
		{
			return false;
		}

		if (is_numeric($userGroupType))
		{
			$userGroupType = 'ALL';
			array_shift($argv);
		}
		else
		{
			$argv = array_slice($argv, 2);
		}

		switch (strtoupper($userGroupType))
		{
			case 'ALL':
				return self::_checkUsergroup($argv, array_merge(
					(array) $visitor['user_group_id'],
					(array) explode(',', $visitor['secondary_group_ids'])
				));
				break;

			case 'PRIMARY':
				return self::_checkUsergroup($argv, (array) $visitor['user_group_id']);
				break;

			case 'SECONDARY':
				return self::_checkUsergroup($argv, (array) explode(',', $visitor['secondary_group_ids']));
				break;

			default:
				return false;
				break;
		}
	}

	/**
	 * Check & return true if ANY of the needle is present in the haystack
	 *
	 * @param array $haystack
	 * @param array $needles
	 * @return boolean
	 */
	protected static function _checkUsergroup(array $haystack, array $needles)
	{
		return (boolean) count(array_intersect($haystack, $needles));
	}
}
