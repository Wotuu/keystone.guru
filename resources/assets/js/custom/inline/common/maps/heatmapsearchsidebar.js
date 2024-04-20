class CommonMapsHeatmapsearchsidebar extends SearchInlineBase {


    constructor(options) {
        super(options);

        this.sidebar = new Sidebar(options);

        this._draggable = null;

        this.searchHandler = new SearchHandlerHeatmap(
            $.extend({}, {
                // loaderSelector: `#route_list_overlay`,
            }, this.options)
        );

        // Previous search params are used to prevent searching for the same thing multiple times for no reason
        this._previousSearchParams = null;

        this.filters = {
            'level': new SearchFilterLevel('#level', this._search.bind(this), this.options.levelMin, this.options.levelMax),
            'affixgroups': new SearchFilterAffixGroups(`.filter_affix.${this.options.currentExpansion} select`, this._search.bind(this)),
            'affixes': new SearchFilterAffixes('.select_icon.class_icon.selectable', this._search.bind(this)),
        };
    }


    /**
     *
     */
    activate() {
        super.activate();

        console.assert(this instanceof CommonMapsHeatmapsearchsidebar, 'this is not a CommonMapsHeatmapsearchsidebar', this);

        this.map = getState().getDungeonMap();

        // let self = this;

        this.sidebar.activate();

        if (this.options.defaultState > 1 && $('#map').width() > this.options.defaultState) {
            this.sidebar.showSidebar();
        }

        this._search();
    }

    _search() {

        super._search();
    }

    /**
     *
     */
    cleanup() {
        console.assert(this instanceof CommonMapsHeatmapsearchsidebar, 'this is not a CommonMapsHeatmapsearchsidebar', this);

    }
}
