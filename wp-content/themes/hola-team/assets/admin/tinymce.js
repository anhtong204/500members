/* eslint-disable */
(function() {
    function updateSelectedBlocksClasses(nodes, add, remove) {
        if (nodes.length > 0) {
            for (var i = 0; i < nodes.length; i++) {
                if (typeof remove === "string") {
                    if (nodes[i].classList.contains(remove)) {
                        nodes[i].classList.remove(remove);
                    }
                } else if (remove.length > 0) {
                    for (var j = 0; j < remove.length; j++) {
                        if (nodes[i].classList.contains(remove[j])) {
                            nodes[i].classList.remove(remove[j]);
                        }
                    }
                }
                if (typeof add === "string") {
                    nodes[i].classList.add(add);
                } else if (add.length > 0) {
                    for (var j = 0; j < add.length; j++) {
                        nodes[i].classList.add(add[j]);
                    }
                }
            }
        }
    }

    tinymce.PluginManager.add("tinymce_font_weight", function(editor, url) {
        editor.addButton("tinymce_font_weight", {
            text: "Font Weight",
            icon: false,
            type: "menubutton",
            menu: [
                {
                    text: "Thin",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--thin"],
                            [
                                "t-font-weight--light",
                                "t-font-weight--regular",
                                "t-font-weight--medium",
                                "t-font-weight--bold",
                                "t-font-weight--heavy"
                            ]
                        );
                    }
                },
                {
                    text: "Light",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--light"],
                            [
                                "t-font-weight--thin",
                                "t-font-weight--regular",
                                "t-font-weight--medium",
                                "t-font-weight--bold",
                                "t-font-weight--heavy"
                            ]
                        );
                    }
                },
                {
                    text: "Regular",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--regular"],
                            [
                                "t-font-weight--light",
                                "t-font-weight--thin",
                                "t-font-weight--medium",
                                "t-font-weight--bold",
                                "t-font-weight--heavy"
                            ]
                        );
                    }
                },
                {
                    text: "Medium",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--medium"],
                            [
                                "t-font-weight--light",
                                "t-font-weight--thin",
                                "t-font-weight--regular",
                                "t-font-weight--bold",
                                "t-font-weight--heavy"
                            ]
                        );
                    }
                },
                {
                    text: "Bold",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--bold"],
                            [
                                "t-font-weight--light",
                                "t-font-weight--thin",
                                "t-font-weight--regular",
                                "t-font-weight--medium",
                                "t-font-weight--heavy"
                            ]
                        );
                    }
                },
                {
                    text: "Heavy",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-font-weight--heavy"],
                            [
                                "t-font-weight--light",
                                "t-font-weight--thin",
                                "t-font-weight--regular",
                                "t-font-weight--medium",
                                "t-font-weight--bold"
                            ]
                        );
                    }
                }
            ]
        });
    });

    tinymce.PluginManager.add("tinymce_font_sizes", function(editor, url) {
        editor.addButton("tinymce_font_sizes", {
            text: "Font Sizes",
            icon: false,
            type: "menubutton",
            menu: [
                {
                    text: "65px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-alpha"],
                            [
                                "t-heading-beta",
                                "t-heading-gamma",
                                "t-heading-delta",
                                "t-heading-epsilon",
                                "t-heading-base"
                            ]
                        );
                    }
                },
                {
                    text: "49px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-beta"],
                            [
                                "t-heading-alpha",
                                "t-heading-gamma",
                                "t-heading-delta",
                                "t-heading-epsilon",
                                "t-heading-base"
                            ]
                        );
                    }
                },
                {
                    text: "39px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-gamma"],
                            [
                                "t-heading-alpha",
                                "t-heading-beta",
                                "t-heading-delta",
                                "t-heading-epsilon",
                                "t-heading-base"
                            ]
                        );
                    }
                },
                {
                    text: "28px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-delta"],
                            [
                                "t-heading-alpha",
                                "t-heading-beta",
                                "t-heading-gamma",
                                "t-heading-epsilon",
                                "t-heading-base"
                            ]
                        );
                    }
                },
                {
                    text: "21px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-epsilon"],
                            [
                                "t-heading-alpha",
                                "t-heading-beta",
                                "t-heading-gamma",
                                "t-heading-delta",
                                "t-heading-base"
                            ]
                        );
                    }
                },
                {
                    text: "16px",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            ["t-heading-base"],
                            [
                                "t-heading-alpha",
                                "t-heading-beta",
                                "t-heading-gamma",
                                "t-heading-delta",
                                "t-heading-epsilon"
                            ]
                        );
                    }
                }
            ]
        });
    });

    tinymce.PluginManager.add("tinymce_font_family", function(editor, url) {
        editor.addButton("tinymce_font_family", {
            text: "Font Family",
            icon: false,
            type: "menubutton",
            menu: [
                {
                    text: "AvenirNext LT Pro",
                    onclick: function() {
                        updateSelectedBlocksClasses(
                            editor.selection.getSelectedBlocks(),
                            "t-font--primary"
                        );
                    }
                }
            ]
        });
    });
})();
/* eslint-enable */
