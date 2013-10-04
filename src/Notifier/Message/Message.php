<?php
/**
 * This file is part of the Notifier package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Notifier\Message;

use Notifier\Contact\ContactInterface;
use Notifier\Recipient\RecipientInterface;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var RecipientInterface[]
     */
    protected $recipients = array();

    /**
     * @var ContactInterface[]
     */
    protected $senders = array();

    /**
     * @var string
     */
    protected $subject = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function addRecipient(RecipientInterface $recipient)
    {
        $this->recipients[] = $recipient;
    }

    /**
     * @return array|RecipientInterface[]
     */
    public function &getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param array|ContactInterface $sender
     */
    public function addSender($sender)
    {
        $this->senders[] = $sender;
    }

    /**
     * @return array|ContactInterface[]
     */
    public function &getSenders()
    {
        return $this->senders;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

}
