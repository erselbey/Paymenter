@once
    @php
        $activeTheme = config('settings.theme');
        $manifestPath = public_path($activeTheme . '/manifest.json');
        $themeAssetsDir = public_path($activeTheme . '/assets');
        $useVite = file_exists($manifestPath);

        $latestAsset = static function (string $pattern): ?string {
            $matches = glob($pattern) ?: [];
            if ($matches === []) {
                return null;
            }

            usort($matches, static fn (string $a, string $b) => filemtime($b) <=> filemtime($a));

            return $matches[0] ?? null;
        };

        $easymdeCssAsset = null;
        $easymdeJsAsset = null;

        if (! $useVite && is_dir($themeAssetsDir)) {
            $easymdeCssFile = $latestAsset($themeAssetsDir . '/easymde-entry-*.css');
            $easymdeJsFile = $latestAsset($themeAssetsDir . '/easymde-entry-*.js');

            $easymdeCssAsset = $easymdeCssFile ? asset($activeTheme . '/assets/' . basename($easymdeCssFile)) : null;
            $easymdeJsAsset = $easymdeJsFile ? asset($activeTheme . '/assets/' . basename($easymdeJsFile)) : null;
        }
    @endphp
    @if ($useVite)
        @vite('themes/' . $activeTheme . '/js/easymde-entry.js', $activeTheme)
    @else
        @if ($easymdeCssAsset)
            <link rel="stylesheet" href="{{ $easymdeCssAsset }}">
        @endif
        @if ($easymdeJsAsset)
            <script type="module" src="{{ $easymdeJsAsset }}"></script>
        @endif
    @endif
@endonce

@script
    <script>
        const initializeEditor = () => {
            const editor = new EasyMDE({
                element: document.getElementById('editor'),
                spellChecker: false,
                previewImagesInEditor: true,
                autoDownloadFontAwesome: false,
                status: [{
                    className: 'upload-image',
                    defaultValue: '',
                }],
                toolbar: [{
                        name: 'bold',
                        action: EasyMDE.toggleBold,
                    }, {
                        name: 'italic',
                        action: EasyMDE.toggleItalic,
                    }, {
                        name: 'strikethrough',
                        action: EasyMDE.toggleStrikethrough,
                    }, {
                        name: 'link',
                        action: EasyMDE.drawLink,
                    }, '|',
                    {
                        name: 'heading',
                        action: EasyMDE.toggleHeadingSmaller,
                    }, '|',
                    {
                        name: 'quote',
                        action: EasyMDE.toggleBlockquote,
                    }, {
                        name: 'code',
                        action: EasyMDE.toggleCodeBlock,

                    }, {
                        name: 'unordered-list',
                        action: EasyMDE.toggleUnorderedList,
                    }, {
                        name: 'ordered-list',
                        action: EasyMDE.toggleOrderedList,
                    }, '|',
                    {
                        name: 'undo',
                        action: EasyMDE.undo,
                    }, {
                        name: 'redo',
                        action: EasyMDE.redo,
                    },

                ],
            });

            editor.codemirror.on('change', function() {
                @this.set('message', editor.value(), false);
            });

            // Listen for event called saved
            $wire.on('saved', () => {
                editor.clearAutosavedValue();
                editor.value('');
            });
        };

        if (window.EasyMDE) {
            initializeEditor();
        } else {
            document.addEventListener('easymde:ready', initializeEditor, { once: true });
        }
    </script>
@endscript
