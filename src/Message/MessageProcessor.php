<?php
/**
 * This file is part of the Notifier package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Notifier\Message;
use Notifier\Processor\ProcessorStore;
use Notifier\Recipient\RecipientInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MessageProcessor
{
    /**
     * @var ProcessorStore
     */
    private $processorStore;

    /**
     * @param ProcessorStore $processorStore
     */
    public function __construct(ProcessorStore $processorStore)
    {
        $this->processorStore = $processorStore;
    }

    /**
     * @return ProcessorStore
     */
    private function getProcessorStore()
    {
        return $this->processorStore;
    }

    /**
     * PreProcess the message.
     *
     * @param  MessageInterface $message
     * @return MessageInterface
     */
    public function preProcessMessage(MessageInterface $message)
    {
        foreach ($this->getProcessorStore()->getProcessors() as $processor) {
            $message = $processor->preProcessMessage($message);
        }

        return $message;
    }

    /**
     * @param  MessageInterface   $message
     * @param  RecipientInterface $recipient
     * @return MessageInterface
     */
    public function processMessage(MessageInterface $message, RecipientInterface $recipient)
    {
        foreach ($this->getProcessorStore()->getProcessors() as $processor) {
            $message = $processor->processMessage($message, $recipient);
        }

        return $message;
    }
}
