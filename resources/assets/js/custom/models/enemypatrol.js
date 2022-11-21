// $(function () {
L.Draw.EnemyPatrol = L.Draw.Polyline.extend({
    statics: {
        TYPE: 'enemypatrol'
    },
    initialize: function (map, options) {
        // Save the type so super can fire, need to do this as cannot do this.TYPE :(
        this.type = L.Draw.EnemyPatrol.TYPE;
        L.Draw.Feature.prototype.initialize.call(this, map, options);
    }
});

// });

class EnemyPatrol extends Polyline {
    constructor(map, layer) {
        super(map, layer, {name: 'enemypatrol', hasRouteModelBinding: true});

        this.weight = c.map.enemypatrol.defaultWeight;

        this.label = 'EnemyPatrol';

        // The assigned enemies to this enemy patrol
        this.enemies = [];
    }


    _getAttributes(force) {
        console.assert(this instanceof EnemyPatrol, 'this was not an EnemyPack', this);

        if (this._cachedAttributes !== null && !force) {
            return this._cachedAttributes;
        }

        let self = this;

        return this._cachedAttributes = super._getAttributes(force).concat([
            new Attribute({
                name: 'couple_enemies',
                type: 'button',
                buttonType: 'info',
                buttonText: lang.get('messages.enemypatrol_couple_enemies_button_text_label'),
                default: getState().getCurrentFloor().id,
                clicked: function (e) {
                    self.map.leafletMap.closePopup();

                    if (self.map.getMapState() instanceof EnemyPatrolEnemySelection) {
                        self.map.setMapState(null);
                    } else {
                        self.map.setMapState(
                            new EnemyPatrolEnemySelection(self.map, self)
                        );
                    }
                }
            })
        ]);
    }

    /**
     *
     * @returns {function}
     * @protected
     */
    _getPolylineColorDefault() {
        return c.map.enemypatrol.defaultColor;
    }

    /**
     * Gets the actual decorator for this map object.
     * @returns {*}
     * @private
     */
    _getDecorator() {
        console.assert(this instanceof EnemyPatrol, 'this was not an EnemyPack', this);

        return L.polylineDecorator(this.layer, {
            patterns: [
                {
                    offset: 12,
                    repeat: 25,
                    symbol: L.Symbol.dash({
                        pixelSize: 10,
                        pathOptions: {color: this.polyline.color, weight: 2}
                    })
                },
                {
                    offset: 25,
                    repeat: 50,
                    symbol: L.Symbol.arrowHead({
                        pixelSize: 12,
                        pathOptions: {fillOpacity: 1, weight: 0, color: this.polyline.color}
                    })
                }
            ]
        });
    }

    /**
     *
     * @returns {*[]}
     * @private
     */
    _getEnemiesLatLngs() {
        let result = [];
        for (let index in this.enemies) {
            let enemyCandidate = this.enemies[index];

            result.push(enemyCandidate.layer.getLatLng());
        }

        return result;
    }

    /**
     *
     * @returns {*}
     */
    getLayerLatLng() {
        let vertices = this.getVertices();

        // Just get the middle one
        return vertices[Math.floor(vertices.length / 2)];
    }

    /**
     *
     * @param enemy
     */
    addEnemy(enemy) {
        this.enemies.push(enemy);
    }

    /**
     *
     * @param enemy
     */
    removeEnemy(enemy) {
        let newEnemies = [];
        for (let index in this.enemies) {
            let enemyCandidate = this.enemies[index];
            if (enemyCandidate.id !== enemy.id) {
                newEnemies.push(enemyCandidate);
                console.log(`Adding ${enemyCandidate.id} to new list of enemies`);
            }
        }

        this.enemies = newEnemies;
    }

    /**
     * Users cannot delete this. AdminEnemyPatrols may be deleted instead.
     * @returns {boolean}
     */
    isDeletable() {
        return false;
    }

    /**
     * Users cannot edit this. AdminEnemyPatrols may be edited instead.
     * @returns {boolean}
     */
    isEditable() {
        return false;
    }

    toString() {
        return `Enemy patrol-${this.id}`;
    }
}
