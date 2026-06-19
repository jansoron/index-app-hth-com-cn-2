<?php

/**
 * SiteMeta - 站点元信息管理
 * 
 * 用于保存站点的基础元数据，并提供生成描述文本的方法。
 */

class SiteMeta {
    private array $data;

    public function __construct(array $meta = []) {
        $this->data = array_merge([
            'name'        => '',
            'url'         => '',
            'keywords'    => [],
            'description' => '',
            'lang'        => 'zh-CN',
            'version'     => '1.0.0',
        ], $meta);
    }

    public function set(string $key, $value): void {
        $this->data[$key] = $value;
    }

    public function get(string $key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    public function addKeyword(string $keyword): void {
        $this->data['keywords'][] = $keyword;
    }

    public function getKeywords(): array {
        return $this->data['keywords'];
    }

    public function getKeywordsString(string $separator = ', '): string {
        return implode($separator, $this->data['keywords']);
    }

    public function generateDescription(): string {
        $parts = [];

        if (!empty($this->data['name'])) {
            $parts[] = $this->data['name'];
        }

        if (!empty($this->data['description'])) {
            $parts[] = $this->data['description'];
        }

        $keywords = $this->getKeywordsString();
        if (!empty($keywords)) {
            $parts[] = '关键词：' . $keywords;
        }

        if (!empty($this->data['url'])) {
            $parts[] = '网址：' . $this->data['url'];
        }

        $text = implode(' - ', $parts);
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public function toArray(): array {
        return $this->data;
    }

    public static function fromJson(string $json): self {
        $meta = json_decode($json, true);
        return new self($meta ?? []);
    }
}

// ---------- 示例数据 ----------
$site = new SiteMeta([
    'name'        => '华体会体育平台',
    'url'         => 'https://index-app-hth.com.cn',
    'description' => '提供丰富的体育赛事资讯与互动体验',
    'lang'        => 'zh-CN',
]);

$site->addKeyword('华体会');
$site->addKeyword('体育');
$site->addKeyword('赛事资讯');

echo "站点名称: " . $site->get('name') . "\n";
echo "站点URL: " . $site->get('url') . "\n";
echo "关键词: " . $site->getKeywordsString() . "\n";
echo "描述文本: " . $site->generateDescription() . "\n";

// 输出数组结构
print_r($site->toArray());