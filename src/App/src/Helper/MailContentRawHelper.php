<?php

declare(strict_types=1);

namespace App\Helper;

use Mail\Helper\MailContentRawHelperInterface;
use Mail\Model\EmailContentModelInterface;
use Mustache_Engine;

final class MailContentRawHelper implements MailContentRawHelperInterface
{
    /** @var array */
    private $variables;

    /** @var EmailContentModelInterface */
    private $emailContentModel;

    public function getCode(): string
    {
        return MailContentRawHelperInterface::MAIL_CODE;
    }

    public function create(EmailContentModelInterface $emailContentModel, array $variables): self
    {
        $this->emailContentModel = $emailContentModel;
        $this->variables         = $variables;

        return $this;
    }

    public function render(string $type): string
    {
        $mustache = new Mustache_Engine();

        return $mustache->render($this->emailContentModel->{'get' . $type}(), $this->variables);
    }
}
