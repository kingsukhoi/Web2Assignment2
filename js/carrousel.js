// <div id="carrousel">
// //     <div id="listPhotos">
// //     <div class="photo-item">1</div>
// //     <div class="photo-item">2</div>
// //     <div class="photo-item">3</div>
// //     </div>
// //     </div>

var Carrousel = new Class(
    {

        Implements: [Events, Options],

        options:
            {
                id: 'carrousel',
                itemsWrapper: 'listPhotos',
                itemClass: '.photo-item',
                mode: 'horizontal',
                buttonPrev: 'previousButton',
                buttonNext: 'nextButton',

                fadeIn: true, //fade [itemsWrapper] in ; or not
                hideControls: true,  //hide [buttonPrev] and [buttonNext] if there is just one item

                duration: 'normal' //'short', 'normal', 'long' or integer
            },

        items: new Array(),
        itemDimensions: null,
        clone: null,
        offset: {top: null, left: null},
        wait: false,
        Flex: null,
        currentID: 0,

        initialize: function (options) {
            this.setOptions(options);
            this.getItems();


            this.itemDimensions = this.items[0].getSize();

            if (this.items.length > 1) {
                if (this.options.mode == "vertical") {
                    this.offset.top = this.itemDimensions.y * -1;
                } else {
                    this.offset.left = this.itemDimensions.x * -1;

                    this.items.each(function (element) {
                        element.set('styles', {float: 'left'});
                    });
                    document.id(this.options.itemsWrapper).set('styles', {width: (this.items.length + 1) * this.itemDimensions.x});
                }


                this.clone = this.items[this.items.length - 1].clone();
                this.clone.inject(document.id(this.options.itemsWrapper), 'top');
                this.getItems(); //refresh list;

                document.id(this.options.id).set('styles', {position: 'relative'});
                document.id(this.options.itemsWrapper).set('styles', {
                    position: 'absolute',
                    left: this.offset.left,
                    top: this.offset.top
                });

                document.id(this.options.buttonNext).addEvent('click', (this.next).bind(this));
                document.id(this.options.buttonPrev).addEvent('click', (this.previous).bind(this));
            } else {
                if (this.options.hideControls) {
                    document.id(this.options.buttonPrev).fade('hide');
                    document.id(this.options.buttonNext).fade('hide');
                }
            }

            this[this.options.mode]();

            if (this.options.fadeIn) document.id(this.options.id).fade('hide').fade('in');
        },

        horizontal: function () {
            this.layout = 'margin-left';
            this.offsetMargin = '-' + this.itemDimensions.x + 'px';
        },
        vertical: function () {
            this.layout = 'margin-top';
            this.offsetMargin = '-' + this.itemDimensions.y + 'px';
        },

        getItems: function () {
            this.items = document.id(this.options.id).getElements(this.options.itemClass);
            this.items.length;
        },

        setCurrent: function (mode) {
            switch (mode) {
                case '+':
                    if (this.currentID + 1 == this.items.length - 1) this.currentID = 0;
                    else this.currentID++;
                    break;
                case '-':
                    if (this.currentID == 0) this.currentID = this.items.length - 2;
                    else this.currentID--;
                    break;
                default:
                    return;
                    break;

            }
        },

        previous: function () {
            if (!this.wait) {
                this.wait = true;
                this.setCurrent("-");

                this.items[this.items.length - 1].destroy(); //remove last item
                this.clone = this.items[this.items.length - 2].clone();
                this.clone.setStyle(this.layout, this.offsetMargin);
                this.clone.inject(document.id(this.options.itemsWrapper), 'top');

                this.fireEvent('previous');

                this.Flex = new Flex.Tween(this.clone, {
                    duration: this.options.duration,
                    onComplete: (function () {
                        this.wait = false;
                        this.getItems();
                        this.fireEvent('complete');
                    }).bind(this)
                }).start(this.layout, 0);

            }
        },

        next: function () {
            if (!this.wait) {
                this.wait = true;
                this.setCurrent("+");

                this.Flex = new Flex.Tween(this.items[0], {
                    duration: this.options.duration,
                    onComplete: (function () {
                        this.items[0].destroy();

                        this.clone = this.items[1].clone();
                        this.clone.inject(document.id(this.options.itemsWrapper));
                        this.getItems(); //refreshes itemslist
                        this.wait = false;
                        this.fireEvent('complete');
                    }).bind(this)
                }).start(this.layout, this.offsetMargin);

                this.fireEvent('next');
            }
        }
    });