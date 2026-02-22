<div class="container py-8 md:py-12">
    <section class="gsc-surface mb-8 rounded-3xl p-6 md:p-8">
        <span class="gsc-pill bg-primary/12 text-primary">Category</span>
        <h1 class="mt-3 text-3xl font-bold md:text-4xl">{{ $category->name }}</h1>
        <article class="prose mt-3 max-w-3xl dark:prose-invert [&_p]:text-base/80">
            {!! $category->description !!}
        </article>
    </section>

    <div class="grid gap-5 lg:grid-cols-12">
        <aside class="flex flex-col gap-5 lg:col-span-3">
            <div class="gsc-surface rounded-2xl p-4">
                <h2 class="text-base font-semibold">Browse Categories</h2>
                <div class="mt-3 flex flex-col gap-1">
                    @foreach ($categories as $ccategory)
                    <a
                        href="{{ route('category.show', ['category' => $ccategory->slug]) }}"
                        wire:navigate
                        class="rounded-xl px-3 py-2 text-sm font-medium transition {{ $category->id === $ccategory->id ? 'bg-primary/14 text-primary' : 'hover:bg-background/60 text-base/85 hover:text-primary' }}">
                        {{ $ccategory->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="gsc-surface rounded-2xl p-4">
                <h3 class="text-base font-semibold">Why this catalog works</h3>
                <ul class="mt-3 space-y-2 text-sm gsc-subtle">
                    <li class="flex items-start gap-2">
                        <x-ri-check-line class="mt-0.5 size-4 text-primary" />
                        Structured plans for fast comparison
                    </li>
                    <li class="flex items-start gap-2">
                        <x-ri-check-line class="mt-0.5 size-4 text-primary" />
                        Streamlined direct checkout flow
                    </li>
                    <li class="flex items-start gap-2">
                        <x-ri-check-line class="mt-0.5 size-4 text-primary" />
                        Clear upgrade path per package
                    </li>
                </ul>
            </div>
        </aside>

        <div class="flex flex-col gap-6 lg:col-span-9">
            @if (count($childCategories) >= 1)
            <section>
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-xl font-semibold md:text-2xl">Subcategories</h2>
                    <span class="gsc-pill bg-secondary/15 text-secondary">{{ count($childCategories) }} options</span>
                </div>

                <div class="gsc-grid gsc-categories">
                    @foreach ($childCategories as $childCategory)
                    <article class="gsc-category-card flex h-full flex-col gap-3 p-5">
                        @if ($childCategory->image)
                        <img
                            src="{{ Storage::url($childCategory->image) }}"
                            alt="{{ $childCategory->name }}"
                            class="{{ theme('small_images', false) ? 'h-14 w-14 rounded-xl object-cover' : 'h-44 w-full rounded-2xl object-cover object-center' }}">
                        @endif

                        <h3 class="text-xl font-semibold">{{ $childCategory->name }}</h3>

                        @if(theme('show_category_description', true))
                        <article class="prose prose-sm max-w-none dark:prose-invert gsc-subtle">
                            {!! $childCategory->description !!}
                        </article>
                        @endif

                        <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate class="mt-auto pt-1">
                            <x-button.secondary>
                                {{ __('common.button.view') }}
                            </x-button.secondary>
                        </a>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <section>
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-xl font-semibold md:text-2xl">Available Plans</h2>
                    <span class="gsc-pill bg-primary/12 text-primary">{{ $products->count() }} plans</span>
                </div>

                <div class="gsc-grid gsc-products">
                    @foreach ($products as $product)
                    @php
                    $canCheckout = $product->stock !== 0 && $product->price()->available;
                    @endphp
                    <article class="gsc-product-card flex h-full flex-col gap-3 p-5">
                        @if ($product->image)
                        <img
                            src="{{ Storage::url($product->image) }}"
                            alt="{{ $product->name }}"
                            class="{{ theme('small_images', false) ? 'h-14 w-14 rounded-xl object-cover' : 'h-44 w-full rounded-2xl object-cover object-center' }}">
                        @endif

                        <div class="flex items-start justify-between gap-3">
                            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                            @if($canCheckout)
                            <span class="gsc-pill bg-primary/14 text-primary">In stock</span>
                            @else
                            <span class="gsc-pill bg-error/15 text-error">Unavailable</span>
                            @endif
                        </div>

                        @if(theme('direct_checkout', false) && $product->description)
                        <article class="prose prose-sm max-w-none dark:prose-invert gsc-subtle">
                            {!! $product->description !!}
                        </article>
                        @endif

                        <div class="mt-1 flex items-end justify-between gap-3">
                            <p class="gsc-price-tag">{{ $product->price()->formatted->price }}</p>
                            <span class="text-xs gsc-subtle">Flexible billing</span>
                        </div>

                        <div class="mt-auto flex items-center gap-2 pt-2">
                            @if($canCheckout && theme('direct_checkout', false))
                            <a href="{{ route('products.checkout', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-grow">
                                <x-button.primary class="w-full">
                                    {{ __('product.add_to_cart') }}
                                </x-button.primary>
                            </a>
                            @else
                            <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-grow">
                                <x-button.primary class="w-full">
                                    {{ __('common.button.view') }}
                                </x-button.primary>
                            </a>
                            @if ($canCheckout)
                            <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}" wire:navigate>
                                <x-button.secondary class="!w-auto !px-3.5">
                                    <x-ri-shopping-bag-4-fill class="size-5" />
                                </x-button.secondary>
                            </a>
                            @endif
                            @endif
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
