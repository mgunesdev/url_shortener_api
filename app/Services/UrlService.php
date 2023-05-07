<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Support\Traits\Conditionable;

class UrlService
{
    use Conditionable;

    protected int $userId;

    protected string $name;
    protected ?string $link;

    protected ?string $slug;

    public function __construct(int $userId, string $name, ?string $link, ?string $slug)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->link = $link;
        $this->slug = $slug;
    }

    /**
     * Get the short URL route prefix.
     *
     * @return string|null
     */
    public function prefix(): ?string
    {
        return trim(config('url.prefix'), '/');
    }

    /**
     * @return Url
     * @throws ApiException
     */
    public function create(): Url
    {
        $this->validate();

        return Url::create([
            'user_id' => $this->userId,
            'name' => $this->name,
            'link' => $this->link,
            'slug' => $this->slug
        ]);
    }

    /**
     * @param $id
     * @return Url
     * @throws ApiException
     */
    public function update($id): Url
    {
        $obj = Url::find($id);
        if (!$obj) {
            throw new ApiException('URL not found.');
        }

        $this->validate();

        $obj->update([
            'name' => $this->name,
            'link' => $this->link,
            'slug' => $this->slug
        ]);

        return $obj;
    }

    /**
     * @return string
     */
    public function generateKey(): string
    {
        $hash = new Hashids(
            config('url.key_salt'),
            config('url.key_min_length')
        );
        return $hash->encode(Carbon::now()->timestamp);
    }

    /**
     * @return void
     * @throws ApiException
     */
    private function validate(): void
    {
        if (!$this->link) {
            throw new ApiException('No destination URL has been set.');
        }

        if (!$this->slug) {
            $this->slug = $this->generateKey();
        }

        if (Url::where('slug', $this->slug)->exists()) {
            throw new ApiException('A short URL with this key already exists.');
        }
    }
}
