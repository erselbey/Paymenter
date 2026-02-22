<div
    x-data="{
        selectOpen: false,
        selectedValue: @entangle($attributes->wire('model')),
        selectableItems: {{ json_encode($options) }},
        selectableItemActive: null,
        selectId: $id('select'),
        selectDropdownPosition: 'bottom',

        init() {
            this.$watch('selectOpen', () => {
                if (this.selectOpen) {
                    this.selectableItemActive = this.selectableItems.find(item => item.value === this.selectedValue) 
                        || this.selectableItems[0];
                    this.$nextTick(() => this.selectScrollToActiveItem());
                }
                this.selectPositionUpdate();
            });

            window.addEventListener('resize', this.resizeHandler = () => this.selectPositionUpdate());
            this.$el.addEventListener('alpine:destroyed', () => window.removeEventListener('resize', this.resizeHandler));
        },

        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value === item.value;
        },

        selectableItemActiveNext() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index < this.selectableItems.length - 1) {
                this.selectableItemActive = this.selectableItems[index + 1];
                this.selectScrollToActiveItem();
            }
        },

        selectableItemActivePrevious() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index > 0) {
                this.selectableItemActive = this.selectableItems[index - 1];
                this.selectScrollToActiveItem();
            }
        },

        selectScrollToActiveItem() {
            if (this.selectableItemActive) {
                const activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId);
                if (activeElement) {
                    activeElement.scrollIntoView({ block: 'nearest' });
                }
            }
        },

        selectPositionUpdate() {
            if (!this.$refs.selectButton || !this.$refs.selectableItemsList) return;
            
            const selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + 
                this.$refs.selectButton.offsetHeight + 
                this.$refs.selectableItemsList.offsetHeight;
            
            this.selectDropdownPosition = window.innerHeight < selectDropdownBottomPos ? 'top' : 'bottom';
        }
    }"
    @keydown.escape="selectOpen = false"
    @keydown.down.prevent="if(selectOpen) { selectableItemActiveNext() } else { selectOpen = true }"
    @keydown.up.prevent="if(selectOpen) { selectableItemActivePrevious() } else { selectOpen = true }"
    @keydown.enter.prevent="selectedValue = selectableItemActive.value; selectOpen = false"
    class="relative w-full"
>
    <button 
        x-ref="selectButton"
        @click="selectOpen = !selectOpen"
        :class="{ 'ring-2 ring-offset-2 ring-primary/30 ring-offset-background': selectOpen }"
        class="relative w-full min-h-[38px] rounded-lg border border-neutral/80 bg-background py-2 pl-3 pr-10 text-left text-sm text-base shadow-sm transition hover:border-primary/30 focus:outline-none focus:ring-2 focus:ring-primary/30"
        type="button"
    >
        <span x-text="selectableItems.find(item => item.value === selectedValue)?.label ?? '{{ $placeholder ?? 'Select option' }}'" class="block truncate"></span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <x-ri-expand-up-down-line class="size-4" />
        </span>
    </button>

    <ul
        x-show="selectOpen"
        x-ref="selectableItemsList"
        @click.away="selectOpen = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        :class="{ 'bottom-full mb-1': selectDropdownPosition === 'top', 'top-full mt-1': selectDropdownPosition === 'bottom' }"
        class="absolute z-50 max-h-60 w-full overflow-auto rounded-lg border border-neutral/80 bg-background py-1 text-sm shadow-lg focus:outline-none"
        x-cloak
    >
        <template x-for="item in selectableItems" :key="item.value">
            <li
                :id="item.value + '-' + selectId"
                @click="selectedValue = item.value; selectOpen = false"
                @mousemove="selectableItemActive = item"
                :class="{ 'bg-primary/12 text-primary': selectableItemIsActive(item) }"
                class="relative cursor-pointer select-none py-2 pl-8 pr-4 text-base/90 hover:bg-primary/10 hover:text-primary"
            >
                <span 
                    class="block truncate"
                    :class="{ 'font-semibold': item.value === selectedValue }"
                    x-text="item.label"
                ></span>
                <span
                    x-show="item.value === selectedValue"
                    class="absolute inset-y-0 left-0 flex items-center pl-2 text-neutral-400"
                >
                    <x-ri-check-fill class="size-4" />
                </span>
            </li>
        </template>
    </ul>
</div>
