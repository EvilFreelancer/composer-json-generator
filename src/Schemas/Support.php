<?php

namespace ComposerJson\Schemas;

use ComposerJson\Model;

/**
 * Support information includes the following:
 *
 * @package ComposerJson\Schemas
 */
class Support extends Model
{
    /**
     * Email address for support.
     *
     * @var string
     */
    public string $email;

    /**
     * URL to the issue tracker.
     *
     * @var string
     */
    public string $issues;

    /**
     * URL to the forum.
     *
     * @var string
     */
    public string $forum;

    /**
     * URL to the wiki.
     *
     * @var string
     */
    public string $wiki;

    /**
     * IRC channel for support, as irc://server/channel.
     *
     * @var string
     */
    public string $irc;

    /**
     * URL to browse or download the sources.
     *
     * @var string
     */
    public string $source;

    /**
     * URL to the documentation.
     *
     * @var string
     */
    public string $docs;

    /**
     * URL to the RSS feed.
     *
     * @var string
     */
    public string $rss;

    /**
     * URL to the chat channel.
     *
     * @var string
     */
    public string $chat;
}
