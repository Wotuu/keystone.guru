class SearchFilterRating extends SearchFilterInput {
    constructor(selector, onChange) {
        super({
            name: 'rating',
            selector: selector,
            onChange: onChange
        });
    }

    activate() {
        super.activate();

        let self = this;

        $(this.options.selector).ionRangeSlider({
            grid: true,
            grid_snap: true,
            min: 1,
            max: 10,
            extra_classes: 'inverse',
            onFinish: function (data) {
                self.options.onChange();
            }
        });
    }

    getFilterHeaderText() {
        return `Rating: ${this.getValue()} and higher`;
    }

    /**
     *
     * @param value
     */
    setValue(value) {
        $(this.options.selector).data('ionRangeSlider').update({
            from: value.split(';')[0],
            to: value.split(';')[1],
        });
    }
}