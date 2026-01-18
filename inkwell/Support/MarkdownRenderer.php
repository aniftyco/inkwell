<?php

namespace NiftyCo\Inkwell\Support;

use Illuminate\Support\Str;

class MarkdownRenderer
{
    public function render(string $markdown): string
    {
        $resolved = $this->resolveAttachments($markdown);

        return Str::markdown($resolved, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function renderInline(string $markdown): string
    {
        $resolved = $this->resolveAttachments($markdown);

        return Str::inlineMarkdown($resolved, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    protected function resolveAttachments(string $content): string
    {
        return preg_replace_callback(
            '/!\[([^\]]*)\]\(attachment:(\d+)\)/',
            function ($matches) {
                $alt = $matches[1];
                $attachmentId = $matches[2];
                $url = $this->getAttachmentUrl($attachmentId);

                if ($url) {
                    return "![{$alt}]({$url})";
                }

                return $matches[0];
            },
            $content
        );
    }

    protected function getAttachmentUrl(int|string $id): ?string
    {
        $attachmentClass = config('inkwell.attachments.model', 'NiftyCo\\Attachments\\Models\\Attachment');

        if (! class_exists($attachmentClass)) {
            return null;
        }

        $attachment = $attachmentClass::find($id);

        if (! $attachment) {
            return null;
        }

        if (method_exists($attachment, 'url')) {
            return $attachment->url();
        }

        if (method_exists($attachment, 'getUrl')) {
            return $attachment->getUrl();
        }

        if (isset($attachment->url)) {
            return $attachment->url;
        }

        return null;
    }

    public function toPlainText(string $markdown): string
    {
        $html = $this->render($markdown);

        return strip_tags($html);
    }

    public function excerpt(string $markdown, int $length = 160): string
    {
        $plainText = $this->toPlainText($markdown);

        return Str::limit($plainText, $length);
    }
}
