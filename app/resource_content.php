<?php
declare(strict_types=1);

/** Safely format the article text stored in resources.body. */
function resource_body_html(string $body): string
{
    $blocks = preg_split('/\R\s*\R/', trim($body)) ?: [];
    $html = '';
    $headings = [
        'What are your options?',
        'What is a Power of Attorney?',
        'Two things families often mix up:',
        'Why this matters',
        'Small ways to find your pace:',
        'A gentle reminder',
    ];
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') continue;
        $lines = preg_split('/\R/', $block) ?: [];
        $isList = $lines && count(array_filter($lines, static fn(string $line): bool => !preg_match('/^[-•]\s+/', trim($line)))) === 0;
        if ($isList) {
            $html .= '<ul>';
            foreach ($lines as $line) {
                $html .= '<li>' . e(preg_replace('/^[-•]\s+/', '', trim($line))) . '</li>';
            }
            $html .= '</ul>';
        } elseif (in_array($block, $headings, true)) {
            $html .= '<h4>' . e($block) . '</h4>';
        } elseif (str_starts_with($block, '“')) {
            $html .= '<blockquote>' . nl2br(e($block)) . '</blockquote>';
        } else {
            $html .= '<p>' . nl2br(e($block)) . '</p>';
        }
    }
    return $html;
}
