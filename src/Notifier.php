<?php
/**
 * This file is part of the Notifier package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Notifier;

use Notifier\Channel\ChannelInterface;
use Notifier\Channel\ChannelStore;
use Notifier\Message\MessageInterface;
use Notifier\Message\MessageProcessor;
use Notifier\Processor\ProcessorInterface;
use Notifier\Processor\ProcessorStore;
use Notifier\Recipient\RecipientBLL;
use Notifier\Recipient\RecipientInterface;
use Notifier\Type\TypeBLL;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Notifier
{
    /**
     * @var ChannelStore
     */
    private $channelStore;

    /**
     * @var ProcessorStore
     */
    private $processorStore;

    /**
     * @var RecipientBLL
     */
    private $recipientBLL;

    /**
     * @var TypeBLL
     */
    private $typeBLL;

    /**
     * Construct Notifier with your own logic.
     *
     * @api
     *
     * @param RecipientBLL $recipientBLL
     * @param TypeBLL      $typeBLL
     */
    public function __construct(RecipientBLL $recipientBLL, TypeBLL $typeBLL)
    {
        $this->recipientBLL = $recipientBLL;
        $this->typeBLL = $typeBLL;
    }

    /**
     * Inject your own processor store.
     *
     * @api
     *
     * @param ProcessorStore $processorStore
     */
    public function setProcessorStore($processorStore)
    {
        $this->processorStore = $processorStore;
    }

    /**
     * Inject your own channel store.
     *
     * @api
     *
     * @param ChannelStore $channelStore
     */
    public function setChannelStore($channelStore)
    {
        $this->channelStore = $channelStore;
    }

    /**
     * @return ChannelStore
     */
    public function getChannelStore()
    {
        if (is_null($this->channelStore)) {
            $this->channelStore = new ChannelStore();
        }

        return $this->channelStore;
    }

    /**
     * Add a channel.
     *
     * @api
     *
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel)
    {
        $this->getChannelStore()
            ->addChannel($channel);
    }

    /**
     * @return ProcessorStore
     */
    public function getProcessorStore()
    {
        if (is_null($this->processorStore)) {
            $this->processorStore = new ProcessorStore();
        }

        return $this->processorStore;
    }

    /**
     * Add a processor.
     *
     * @api
     *
     * @param ProcessorInterface $processor
     */
    public function addProcessor(ProcessorInterface $processor)
    {
        $this->getProcessorStore()
            ->addProcessor($processor);
    }

    /**
     * Send a message to any number of recipients.
     *
     * @api
     *
     * @param MessageInterface     $message
     * @param RecipientInterface[] $recipients
     */
    public function sendMessage(MessageInterface $message, array $recipients)
    {
        $messageProcessor = new MessageProcessor($this->getProcessorStore());
        $message = $messageProcessor->preProcessMessage($message);

        foreach ($recipients as $recipient) {
            foreach ($this->getChannels($message, $recipient) as $channel) {
                $processedMessage = $messageProcessor
                    ->processMessage(clone($message), $recipient);
                if ($channel->isHandling($processedMessage)) {
                    $channel->send($processedMessage, $recipient);
                }
            }
        }
    }

    /**
     * Apply all logic to get the correct channels for the current recipient.
     *
     * @param  MessageInterface   $message
     * @param  RecipientInterface $recipient
     * @return ChannelInterface[]
     */
    private function getChannels(MessageInterface $message, RecipientInterface $recipient)
    {
        $channels = $this->typeBLL
            ->getChannels($message->getType());

        return $this->recipientBLL
            ->filterChannels($recipient, $message->getType(), $channels);
    }
}
