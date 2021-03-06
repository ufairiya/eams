var App = function() {
    var isIE8 = false;
    var isIE9 = false;
    var currentPage = '';
    var setEqualHeight = function(columns) {
        var tallestColumn = 0;
        columns = jQuery(columns);
        columns.each(function() {
            var currentHeight = $(this).height();
            if (currentHeight > tallestColumn) {
                tallestColumn = currentHeight;
            }
        });
        columns.height(tallestColumn);
    }
    var handleResponsive = function() {
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) == 8) {
            isIE8 = true;
            $('.visible-ie8').show();
        }
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) == 9) {
            isIE9 = true;
        }
        var isIE10 = !!navigator.userAgent.match(/MSIE 10/);
        if (isIE10) {
            jQuery('html').addClass('ie10');
        }
        var handleTabletElements = function() {
            if ($(window).width() <= 1280) {
                $(".responsive").each(function() {
                    var forTablet = $(this).attr('data-tablet');
                    var forDesktop = $(this).attr('data-desktop');
                    if (forTablet) {
                        $(this).removeClass(forDesktop);
                        $(this).addClass(forTablet);
                    }
                });
                handleTooltip();
            }
        }
        var handleDesktopElements = function() {
            if ($(window).width() > 1280) {
                $(".responsive").each(function() {
                    var forTablet = $(this).attr('data-tablet');
                    var forDesktop = $(this).attr('data-desktop');
                    if (forTablet) {
                        $(this).removeClass(forTablet);
                        $(this).addClass(forDesktop);
                    }
                });
                handleTooltip();
            }
        }
        var handleElements = function() {
            if (App.isPage("index")) {
                handleDashboardCalendar();
                jQuery('.vmaps').each(function() {
                    var map = jQuery(this);
                    map.width(map.parent().width());
                });
            }
            if (App.isPage("charts")) {
                handleChartGraphs();
            }
            if (App.isPage("maps_vector")) {
                jQuery('.vmaps').each(function() {
                    var map = jQuery(this);
                    map.width(map.parent().width());
                });
            }
            if (App.isPage("calendar")) {
                handleCalendar();
            }
            if ($(window).width() < 900) {
                $.cookie('sidebar-closed', null);
                $('.page-container').removeClass("sidebar-closed");
            }
            handleTabletElements();
            handleDesktopElements();
        }
        $(window).setBreakpoints({
            breakpoints: [320, 480, 768, 900, 1024, 1280]
        });
        $(window).bind('exitBreakpoint320', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint320', function() {
            handleElements();
        });
        $(window).bind('exitBreakpoint480', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint480', function() {
            handleElements();
        });
        $(window).bind('exitBreakpoint768', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint768', function() {
            handleElements();
        });
        $(window).bind('exitBreakpoint900', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint900', function() {
            handleElements();
        });
        $(window).bind('exitBreakpoint1024', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint1024', function() {
            handleElements();
        });
        $(window).bind('exitBreakpoint1280', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint1280', function() {
            handleElements();
        });
    }
    var handleJQVMAP = function() {
        var showMap = function(name) {
            jQuery('.vmaps').hide();
            jQuery('#vmap_' + name).show();
        }
        var setMap = function(name) {  
        }
        setMap("world");
        setMap("usa");
        setMap("europe");
        setMap("russia");
        setMap("germany");
        showMap("world");
        jQuery('#regional_stat_world').click(function() {
            showMap("world");
        });
        jQuery('#regional_stat_usa').click(function() {
            showMap("usa");
        });
        jQuery('#regional_stat_europe').click(function() {
            showMap("europe");
        });
        jQuery('#regional_stat_russia').click(function() {
            showMap("russia");
        });
        jQuery('#regional_stat_germany').click(function() {
            showMap("germany");
        });
        $('#region_statistics_loading').hide();
        $('#region_statistics_content').show();
    }
    var handleAllJQVMAP = function() {
        var setMap = function(name) {
            var data = {
                map: 'world_en',
                backgroundColor: null,
                borderColor: '#333333',
                borderOpacity: 0.5,
                borderWidth: 1,
                color: '#c6c6c6',
                enableZoom: true,
                hoverColor: '#c9dfaf',
                hoverOpacity: null,
                values: sample_data,
                normalizeFunction: 'linear',
                scaleColors: ['#b6da93', '#427d1a'],
                selectedColor: '#c9dfaf',
                selectedRegion: null,
                showTooltip: true,
                onRegionOver: function(event, code) {
                    if (code == 'ca') {
                        event.preventDefault();
                    }
                },
                onRegionClick: function(element, code, region) {
                    var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                    alert(message);
                }
            };
            data.map = name + '_en';
            var map = jQuery('#vmap_' + name);
            if (!map) {
                return;
            }
            map.width(map.parent().width());
            map.vectorMap(data);
        }
        setMap("world");
        setMap("usa");
        setMap("europe");
        setMap("russia");
        setMap("germany");
    }
    var handleDashboardCalendar = function() {
        if (!jQuery().fullCalendar) {
            return;
        }
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var h = {};
        if ($('#calendar').width() <= 500) {
            $('#calendar').addClass("mobile");
            h = {
                left: 'title, prev, next',
                center: '',
                right: 'today,month,agendaWeek,agendaDay'
            };
        } else {
            $('#calendar').removeClass("mobile");
            h = {
                left: 'title',
                center: '',
                right: 'prev,next,today,month,agendaWeek,agendaDay'
            };
        }
        $('#calendar').html("");
        $('#calendar').fullCalendar({
            disableDragging: true,
            header: h,
            editable: true,
            events: [{
                title: 'All Day Event',
                start: new Date(y, m, 1),
            }, {
                title: 'Long Event',
                start: new Date(y, m, d - 5),
                end: new Date(y, m, d - 2),
            }, {
                title: 'Repeating Event',
                start: new Date(y, m, d - 3, 16, 0),
                allDay: false,
            }, {
                title: 'Repeating Event',
                start: new Date(y, m, d + 4, 16, 0),
                allDay: false,
            }, {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false,
            }, {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false,
            }, {
                title: 'Birthday Party',
                start: new Date(y, m, d + 1, 19, 0),
                end: new Date(y, m, d + 1, 22, 30),
                allDay: false,
            }, {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/',
            }]
        });
    }
    var handleCalendar = function() {
        if (!jQuery().fullCalendar) {
            return;
        }
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var h = {};
        if ($('#calendar').parents(".portlet").width() <= 720) {
            $('#calendar').addClass("mobile");
            h = {
                left: 'title, prev,next',
                center: '',
                right: 'today,month,agendaWeek,agendaDay'
            };
        } else {
            $('#calendar').removeClass("mobile");
            h = {
                left: 'title',
                center: '',
                right: 'prev,next,today,month,agendaWeek,agendaDay'
            };
        }
        var initDrag = function(el) {
            var eventObject = {
                title: $.trim(el.text())
            };
            el.data('eventObject', eventObject);
            el.draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        }
        var addEvent = function(title) {
            title = title.length == 0 ? "Untitled Event" : title;
            var html = $('<div class="external-event label">' + title + '</div>');
            jQuery('#event_box').append(html);
            initDrag(html);
        }
        $('#external-events div.external-event').each(function() {
            initDrag($(this))
        });
        $('#event_add').unbind('click').click(function() {
            var title = $('#event_title').val();
            addEvent(title);
        });
        $('#event_box').html("");
        addEvent("My Event 1");
        addEvent("My Event 2");
        addEvent("My Event 3");
        addEvent("My Event 4");
        addEvent("My Event 5");
        addEvent("My Event 6");
        $('#calendar').html("");
        $('#calendar').fullCalendar({
            header: h,
            editable: true,
            droppable: true,
            drop: function(date, allDay) {
                var originalEventObject = $(this).data('eventObject');
                var copiedEventObject = $.extend({}, originalEventObject);
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.className = $(this).attr("data-class");
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                if ($('#drop-remove').is(':checked')) {
                    $(this).remove();
                }
            },
            events: [{
                title: 'All Day Event',
                start: new Date(y, m, 1)
            }, {
                title: 'Long Event',
                start: new Date(y, m, d - 5),
                end: new Date(y, m, d - 2)
            }, {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d - 3, 16, 0),
                allDay: false
            }, {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d + 4, 16, 0),
                allDay: false
            }, {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false
            }, {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            }, {
                title: 'Birthday Party',
                start: new Date(y, m, d + 1, 19, 0),
                end: new Date(y, m, d + 1, 22, 30),
                allDay: false
            }, {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }]
        });
    }
    var handleMainMenu = function() {
        jQuery('.page-sidebar .has-sub > a').click(function() {
            var handleContentHeight = function() {
                var content = $('.page-content');
                var sidebar = $('.page-sidebar');
                if (!content.attr("data-height")) {
                    content.attr("data-height", content.height());
                }
                if (sidebar.height() > content.height()) {
                    content.css("min-height", sidebar.height() + 20);
                } else {
                    content.css("min-height", content.attr("data-height"));
                }
            }
            var last = jQuery('.has-sub.open', $('.page-sidebar'));
            if (last.size() == 0) {}
            last.removeClass("open");
            jQuery('.arrow', last).removeClass("open");
            jQuery('.sub', last).slideUp(200);
            var sub = jQuery(this).next();
            if (sub.is(":visible")) {
                jQuery('.arrow', jQuery(this)).removeClass("open");
                jQuery(this).parent().removeClass("open");
                sub.slideUp(200, function() {
                    handleContentHeight();
                });
            } else {
                jQuery('.arrow', jQuery(this)).addClass("open");
                jQuery(this).parent().addClass("open");
                sub.slideDown(200, function() {
                    handleContentHeight();
                });
            }
        });
    }
    var handleSidebarToggler = function() {
        var container = $(".page-container");
        if ($.cookie('sidebar-closed') == 1) {
            container.addClass("sidebar-closed");
        }
        $('.page-sidebar .sidebar-toggler').click(function() {
            $(".sidebar-search").removeClass("open");
            var container = $(".page-container");
            if (container.hasClass("sidebar-closed") === true) {
                container.removeClass("sidebar-closed");
                $.cookie('sidebar-closed', null);
            } else {
                container.addClass("sidebar-closed");
                $.cookie('sidebar-closed', 1);
            }
            if (App.isPage("charts")) {
                setTimeout(function() {
                    handleChartGraphs();
                }, 100);
            }
        });
        $('.sidebar-search .remove').click(function() {
            $('.sidebar-search').removeClass("open");
        });
        $('.sidebar-search input').keypress(function(e) {
            if (e.which == 13) {
                window.location.href = "extra_search.html";
                return false;
            }
        });
        $('.sidebar-search .submit').click(function() {
            if ($('.page-container').hasClass("sidebar-closed")) {
                if ($('.sidebar-search').hasClass('open') == false) {
                    $('.sidebar-search').addClass("open");
                } else {
                    window.location.href = "extra_search.html";
                }
            } else {
                window.location.href = "extra_search.html";
            }
        });
    }
    var handlePortletTools = function() {
        jQuery('.portlet .tools a.remove').click(function() {
            var removable = jQuery(this).parents(".portlet");
            if (removable.next().hasClass('portlet') || removable.prev().hasClass('portlet')) {
                jQuery(this).parents(".portlet").remove();
            } else {
                jQuery(this).parents(".portlet").parent().remove();
            }
        });
        jQuery('.portlet .tools a.reload').click(function() {
            var el = jQuery(this).parents(".portlet");
            App.blockUI(el);
            window.setTimeout(function() {
                App.unblockUI(el);
            }, 1000);
        });
        jQuery('.portlet .tools .collapse, .portlet .tools .expand').click(function() {
            var el = jQuery(this).parents(".portlet").children(".portlet-body");
            if (jQuery(this).hasClass("collapse")) {
                jQuery(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });
    }
    var handlePortletSortable = function() {
        if (!jQuery().sortable) {
            return;
        }
        $("#sortable_portlets").sortable({
            connectWith: ".portlet",
            items: ".portlet",
            opacity: 0.8,
            coneHelperSize: true,
            placeholder: 'sortable-box-placeholder round-all',
            forcePlaceholderSize: true,
            tolerance: "pointer"
        });
        $(".column").disableSelection();
    }
    var handleDashboardCharts = function() {
        if (!jQuery.plot) {
            return;
        }
        var data = [];
        var totalPoints = 250;

        function getRandomData() {
            if (data.length > 0) data = data.slice(1);
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50;
                var y = prev + Math.random() * 10 - 5;
                if (y < 0) y = 0;
                if (y > 100) y = 100;
                data.push(y);
            }
            var res = [];
            for (var i = 0; i < data.length; ++i) res.push([i, data[i]])
            return res;
        }

        function showTooltip(title, x, y, contents) {
            $('<div id="tooltip" class="chart-tooltip"><div class="date">' + title + '<\/div><div class="label label-success">CTR: ' + x / 10 + '%<\/div><div class="label label-important">Imp: ' + x * 12 + '<\/div><\/div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 100,
                width: 75,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff',
            }).appendTo("body").fadeIn(200);
        }

        function randValue() {
            return (Math.floor(Math.random() * (1 + 50 - 20))) + 10;
        }
        var pageviews = [
            [1, randValue()],
            [2, randValue()],
            [3, 2 + randValue()],
            [4, 3 + randValue()],
            [5, 5 + randValue()],
            [6, 10 + randValue()],
            [7, 15 + randValue()],
            [8, 20 + randValue()],
            [9, 25 + randValue()],
            [10, 30 + randValue()],
            [11, 35 + randValue()],
            [12, 25 + randValue()],
            [13, 15 + randValue()],
            [14, 20 + randValue()],
            [15, 45 + randValue()],
            [16, 50 + randValue()],
            [17, 65 + randValue()],
            [18, 70 + randValue()],
            [19, 85 + randValue()],
            [20, 80 + randValue()],
            [21, 75 + randValue()],
            [22, 80 + randValue()],
            [23, 75 + randValue()],
            [24, 70 + randValue()],
            [25, 65 + randValue()],
            [26, 75 + randValue()],
            [27, 80 + randValue()],
            [28, 85 + randValue()],
            [29, 90 + randValue()],
            [30, 95 + randValue()]
        ];
        var visitors = [
            [1, randValue() - 5],
            [2, randValue() - 5],
            [3, randValue() - 5],
            [4, 6 + randValue()],
            [5, 5 + randValue()],
            [6, 20 + randValue()],
            [7, 25 + randValue()],
            [8, 36 + randValue()],
            [9, 26 + randValue()],
            [10, 38 + randValue()],
            [11, 39 + randValue()],
            [12, 50 + randValue()],
            [13, 51 + randValue()],
            [14, 12 + randValue()],
            [15, 13 + randValue()],
            [16, 14 + randValue()],
            [17, 15 + randValue()],
            [18, 15 + randValue()],
            [19, 16 + randValue()],
            [20, 17 + randValue()],
            [21, 18 + randValue()],
            [22, 19 + randValue()],
            [23, 20 + randValue()],
            [24, 21 + randValue()],
            [25, 14 + randValue()],
            [26, 24 + randValue()],
            [27, 25 + randValue()],
            [28, 26 + randValue()],
            [29, 27 + randValue()],
            [30, 31 + randValue()]
        ];
        $('#site_statistics_loading').hide();
        $('#site_statistics_content').show();
        var plot_statistics = $.plot($("#site_statistics"), [{
            data: pageviews,
            label: "Unique Visits"
        }, {
            data: visitors,
            label: "Page Views"
        }], {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.05
                        }, {
                            opacity: 0.01
                        }]
                    }
                },
                points: {
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
            colors: ["#d12610", "#37b7f3", "#52e136"],
            xaxis: {
                ticks: 11,
                tickDecimals: 0
            },
            yaxis: {
                ticks: 11,
                tickDecimals: 0
            }
        });
        var previousPoint = null;
        $("#site_statistics").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    showTooltip('24 Jan 2013', item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
        $('#load_statistics_loading').hide();
        $('#load_statistics_content').show();
        var updateInterval = 30;
        var plot_statistics = $.plot($("#load_statistics"), [getRandomData()], {
            series: {
                shadowSize: 1
            },
            lines: {
                show: true,
                lineWidth: 0.2,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.1
                    }, {
                        opacity: 1
                    }]
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                tickFormatter: function(v) {
                    return v + "%";
                }
            },
            xaxis: {
                show: false
            },
            colors: ["#e14e3d"],
            grid: {
                tickColor: "#a8a3a3",
                borderWidth: 0
            }
        });

        function statisticsUpdate() {
            plot_statistics.setData([getRandomData()]);
            plot_statistics.draw();
            setTimeout(statisticsUpdate, updateInterval);
        }
        statisticsUpdate();
        var previousPoint2 = null;
        $('#site_activities_loading').hide();
        $('#site_activities_content').show();
        var activities = [
            [1, 10],
            [2, 9],
            [3, 8],
            [4, 6],
            [5, 5],
            [6, 3],
            [7, 9],
            [8, 10],
            [9, 12],
            [10, 14],
            [11, 15],
            [12, 13],
            [13, 11],
            [14, 10],
            [15, 9],
            [16, 8],
            [17, 12],
            [18, 14],
            [19, 16],
            [20, 19],
            [21, 20],
            [22, 20],
            [23, 19],
            [24, 17],
            [25, 15],
            [25, 14],
            [26, 12],
            [27, 10],
            [28, 8],
            [29, 10],
            [30, 12],
            [31, 10],
            [32, 9],
            [33, 8],
            [34, 6],
            [35, 5],
            [36, 3],
            [37, 9],
            [38, 10],
            [39, 12],
            [40, 14],
            [41, 15],
            [42, 13],
            [43, 11],
            [44, 10],
            [45, 9],
            [46, 8],
            [47, 12],
            [48, 14],
            [49, 16],
            [50, 12],
            [51, 10]
        ];
        var plot_activities = $.plot($("#site_activities"), [{
            data: activities,
            color: "rgba(107,207,123, 0.9)",
            shadowSize: 0,
            bars: {
                show: true,
                lineWidth: 0,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }
            }
        }], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.9
                }
            },
            grid: {
                show: false,
                hoverable: true,
                clickable: false,
                autoHighlight: true,
                borderWidth: 0
            },
            yaxis: {
                min: 0,
                max: 20
            }
        });
        $("#site_activities").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint2 != item.dataIndex) {
                    previousPoint2 = item.dataIndex;
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    showTooltip('24 Feb 2013', item.pageX, item.pageY, x);
                }
            }
        });
        $('#site_activities, #load_statistics').bind("mouseleave", function() {
            $("#tooltip").remove();
        });
    }
    var handleCharts = function() {
        if (!jQuery.plot) {
            return;
        }
        var data = [];
        var totalPoints = 250;

        function getRandomData() {
            if (data.length > 0) data = data.slice(1);
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50;
                var y = prev + Math.random() * 10 - 5;
                if (y < 0) y = 0;
                if (y > 100) y = 100;
                data.push(y);
            }
            var res = [];
            for (var i = 0; i < data.length; ++i) res.push([i, data[i]])
            return res;
        }

        function chart1() {
            var d1 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.25)
                d1.push([i, Math.sin(i)]);
            var d2 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.25)
                d2.push([i, Math.cos(i)]);
            var d3 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.1)
                d3.push([i, Math.tan(i)]);
            $.plot($("#chart_1"), [{
                label: "sin(x)",
                data: d1
            }, {
                label: "cos(x)",
                data: d2
            }, {
                label: "tan(x)",
                data: d3
            }], {
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                xaxis: {
                    ticks: [0, [Math.PI / 2, "\u03c02"],
                        [Math.PI, "\u03c0"],
                        [Math.PI * 3 / 2, "3\u03c02"],
                        [Math.PI * 2, "2\u03c0"]
                    ]
                },
                yaxis: {
                    ticks: 10,
                    min: -2,
                    max: 2
                },
                grid: {
                    backgroundColor: {
                        colors: ["#fff", "#eee"]
                    }
                }
            });
        }

        function chart2() {
            function randValue() {
                return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
            }
            var pageviews = [
                [1, randValue()],
                [2, randValue()],
                [3, 2 + randValue()],
                [4, 3 + randValue()],
                [5, 5 + randValue()],
                [6, 10 + randValue()],
                [7, 15 + randValue()],
                [8, 20 + randValue()],
                [9, 25 + randValue()],
                [10, 30 + randValue()],
                [11, 35 + randValue()],
                [12, 25 + randValue()],
                [13, 15 + randValue()],
                [14, 20 + randValue()],
                [15, 45 + randValue()],
                [16, 50 + randValue()],
                [17, 65 + randValue()],
                [18, 70 + randValue()],
                [19, 85 + randValue()],
                [20, 80 + randValue()],
                [21, 75 + randValue()],
                [22, 80 + randValue()],
                [23, 75 + randValue()],
                [24, 70 + randValue()],
                [25, 65 + randValue()],
                [26, 75 + randValue()],
                [27, 80 + randValue()],
                [28, 85 + randValue()],
                [29, 90 + randValue()],
                [30, 95 + randValue()]
            ];
            var visitors = [
                [1, randValue() - 5],
                [2, randValue() - 5],
                [3, randValue() - 5],
                [4, 6 + randValue()],
                [5, 5 + randValue()],
                [6, 20 + randValue()],
                [7, 25 + randValue()],
                [8, 36 + randValue()],
                [9, 26 + randValue()],
                [10, 38 + randValue()],
                [11, 39 + randValue()],
                [12, 50 + randValue()],
                [13, 51 + randValue()],
                [14, 12 + randValue()],
                [15, 13 + randValue()],
                [16, 14 + randValue()],
                [17, 15 + randValue()],
                [18, 15 + randValue()],
                [19, 16 + randValue()],
                [20, 17 + randValue()],
                [21, 18 + randValue()],
                [22, 19 + randValue()],
                [23, 20 + randValue()],
                [24, 21 + randValue()],
                [25, 14 + randValue()],
                [26, 24 + randValue()],
                [27, 25 + randValue()],
                [28, 26 + randValue()],
                [29, 27 + randValue()],
                [30, 31 + randValue()]
            ];
            var plot = $.plot($("#chart_2"), [{
                data: pageviews,
                label: "Unique Visits"
            }, {
                data: visitors,
                label: "Page Views"
            }], {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.05
                            }, {
                                opacity: 0.01
                            }]
                        }
                    },
                    points: {
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderWidth: 0
                },
                colors: ["#d12610", "#37b7f3", "#52e136"],
                xaxis: {
                    ticks: 11,
                    tickDecimals: 0
                },
                yaxis: {
                    ticks: 11,
                    tickDecimals: 0
                }
            });

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 15,
                    border: '1px solid #333',
                    padding: '4px',
                    color: '#fff',
                    'border-radius': '3px',
                    'background-color': '#333',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }
            var previousPoint = null;
            $("#chart_2").bind("plothover", function(event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);
                        showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        }

        function chart3() {
            var sin = [],
                cos = [];
            for (var i = 0; i < 14; i += 0.1) {
                sin.push([i, Math.sin(i)]);
                cos.push([i, Math.cos(i)]);
            }
            plot = $.plot($("#chart_3"), [{
                data: sin,
                label: "sin(x) = -0.00"
            }, {
                data: cos,
                label: "cos(x) = -0.00"
            }], {
                series: {
                    lines: {
                        show: true
                    }
                },
                crosshair: {
                    mode: "x"
                },
                grid: {
                    hoverable: true,
                    autoHighlight: false
                },
                yaxis: {
                    min: -1.2,
                    max: 1.2
                }
            });
            var legends = $("#chart_3 .legendLabel");
            legends.each(function() {
                $(this).css('width', $(this).width());
            });
            var updateLegendTimeout = null;
            var latestPosition = null;

            function updateLegend() {
                updateLegendTimeout = null;
                var pos = latestPosition;
                var axes = plot.getAxes();
                if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max || pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) return;
                var i, j, dataset = plot.getData();
                for (i = 0; i < dataset.length; ++i) {
                    var series = dataset[i];
                    for (j = 0; j < series.data.length; ++j)
                        if (series.data[j][0] > pos.x) break;
                    var y, p1 = series.data[j - 1],
                        p2 = series.data[j];
                    if (p1 == null) y = p2[1];
                    else if (p2 == null) y = p1[1];
                    else y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);
                    legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
                }
            }
            $("#chart_3").bind("plothover", function(event, pos, item) {
                latestPosition = pos;
                if (!updateLegendTimeout) updateLegendTimeout = setTimeout(updateLegend, 50);
            });
        }

        function chart4() {
            var options = {
                series: {
                    shadowSize: 1
                },
                lines: {
                    show: true,
                    lineWidth: 0.5,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.1
                        }, {
                            opacity: 1
                        }]
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    tickFormatter: function(v) {
                        return v + "%";
                    }
                },
                xaxis: {
                    show: false
                },
                colors: ["#6ef146"],
                grid: {
                    tickColor: "#a8a3a3",
                    borderWidth: 0
                }
            };
            var updateInterval = 30;
            var plot = $.plot($("#chart_4"), [getRandomData()], options);

            function update() {
                plot.setData([getRandomData()]);
                plot.draw();
                setTimeout(update, updateInterval);
            }
            update();
        }

        function chart5() {
            var d1 = [];
            for (var i = 0; i <= 10; i += 1)
                d1.push([i, parseInt(Math.random() * 30)]);
            var d2 = [];
            for (var i = 0; i <= 10; i += 1)
                d2.push([i, parseInt(Math.random() * 30)]);
            var d3 = [];
            for (var i = 0; i <= 10; i += 1)
                d3.push([i, parseInt(Math.random() * 30)]);
            var stack = 0,
                bars = true,
                lines = false,
                steps = false;

            function plotWithOptions() {
                $.plot($("#chart_5"), [d1, d2, d3], {
                    series: {
                        stack: stack,
                        lines: {
                            show: lines,
                            fill: true,
                            steps: steps
                        },
                        bars: {
                            show: bars,
                            barWidth: 0.6
                        }
                    }
                });
            }
            $(".stackControls input").click(function(e) {
                e.preventDefault();
                stack = $(this).val() == "With stacking" ? true : null;
                plotWithOptions();
            });
            $(".graphControls input").click(function(e) {
                e.preventDefault();
                bars = $(this).val().indexOf("Bars") != -1;
                lines = $(this).val().indexOf("Lines") != -1;
                steps = $(this).val().indexOf("steps") != -1;
                plotWithOptions();
            });
            plotWithOptions();
        }
        chart1();
        chart2();
        chart3();
        chart4();
        chart5();
    }
    var handleChartGraphs = function() {
        var graphData = [];
        var series = Math.floor(Math.random() * 10) + 2;
        for (var i = 0; i < series; i++) {
            graphData[i] = {
                label: "Series" + (i + 1),
                data: Math.floor((Math.random() - 1) * 100) + 1
            }
        }
        $.plot($("#graph_1"), graphData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 1,
                        formatter: function(label, series) {
                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                        },
                        background: {
                            opacity: 0.8
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        $.plot($("#graph_2"), graphData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: function(label, series) {
                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                        },
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        $.plot($("#graph_3"), graphData, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            }
        });
        $("#graph_3").bind("plothover", pieHover);
        $("#graph_3").bind("plotclick", pieClick);

        function pieHover(event, pos, obj) {
            if (!obj) return;
            percent = parseFloat(obj.series.percent).toFixed(2);
            $("#hover").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
        }

        function pieClick(event, pos, obj) {
            if (!obj) return;
            percent = parseFloat(obj.series.percent).toFixed(2);
            alert('' + obj.series.label + ': ' + percent + '%');
        }
        $.plot($("#graph_4"), graphData, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true
                }
            }
        });
    }
    var handleFancyBox = function() {
        if (!jQuery.fancybox) {
            return;
        }
        if (jQuery(".fancybox-button").size() > 0) {
            jQuery(".fancybox-button").fancybox({
                groupAttr: 'data-rel',
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });
        }
    }
    var handleLoginForm = function() {
		 $('.login-form').validate({
			 errorElement: 'label',
            errorClass: 'help-inline',
            focusInvalid: false,
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },
            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },
            invalidHandler: function(event, validator) {
                $('.alert-error', $('.login-form')).show();
            },
            highlight: function(element) {
                $(element).closest('.control-group').addClass('error');
            },
            success: function(label) {
                label.closest('.control-group').removeClass('error');
                label.remove();
            },
            errorPlacement: function(error, element) {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
            },
            submitHandler: function(form) {
				window.location.href = 'login.php';	 
		 form.submit();
		 $(form).keydown(function (e) {     
var charCode = e.charCode || e.keyCode || e.which;
if (charCode  == 13) {
 window.location.href = 'login.php';	 
		 form.submit();
return true;
}
});
				
                   
			}
        });
		        
        $('.forget-form').validate({
            errorElement: 'label',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is required."
                }
            },
            invalidHandler: function(event, validator) {},
            highlight: function(element) {
                $(element).closest('.control-group').addClass('error');
            },
            success: function(label) {
                label.closest('.control-group').removeClass('error');
                label.remove();
            },
            errorPlacement: function(error, element) {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
            },
            submitHandler: function(form) {
                window.location.href = "login.php";
            }
        });
        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    window.location.href = "login.php";
                }
                return false;
            }
        });
        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });
        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });
        $('.register-form').validate({
            errorElement: 'label',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },
                email: {
                    required: true,
                    email: true
                },
                tnc: {
                    required: true
                }
            },
            messages: {
                tnc: {
                    required: "Please accept TNC first."
                }
            },
            invalidHandler: function(event, validator) {},
            highlight: function(element) {
                $(element).closest('.control-group').addClass('error');
            },
            success: function(label) {
                label.closest('.control-group').removeClass('error');
                label.remove();
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") {
                    error.addClass('help-small no-left-padding').insertAfter($('#register_tnc_error'));
                } else {
                    error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
                }
            },
            submitHandler: function(form) {
                window.location.href = "login.php";
            }
        });
        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });
        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }
    var handleFixInputPlaceholderForIE = function() {
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) <= 9) {
            jQuery('input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)').each(function() {
                var input = jQuery(this);
                jQuery(input).addClass("placeholder").val(input.attr('placeholder'));
                jQuery(input).focus(function() {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });
                jQuery(input).blur(function() {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }
    var handlePulsate = function() {
        if (!jQuery().pulsate) {
            return;
        }
        if (isIE8 == true) {
            return;
        }
        if (jQuery().pulsate) {
            jQuery('#pulsate-regular').pulsate({
                color: "#bf1c56"
            });
            jQuery('#pulsate-once').click(function() {
                $(this).pulsate({
                    color: "#399bc3",
                    repeat: false
                });
            });
            jQuery('#pulsate-hover').pulsate({
                color: "#5ebf5e",
                repeat: false,
                onHover: true
            });
            jQuery('#pulsate-crazy').click(function() {
                $(this).pulsate({
                    color: "#fdbe41",
                    reach: 50,
                    repeat: 10,
                    speed: 100,
                    glow: true
                });
            });
        }
    }
    var handleIntro = function() {
        if ($.cookie('intro_show')) {
            return;
        }
        $.cookie('intro_show', 1);
        setTimeout(function() {
            var unique_id = $.gritter.add({
                title: 'Meet Metronic!',
                text: 'Metronic is a brand new Responsive Admin Dashboard Template you have always been looking for!',
                image: './assets/img/avatar1.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            setTimeout(function() {
                $.gritter.remove(unique_id, {
                    fade: true,
                    speed: 'slow'
                });
            }, 12000);
        }, 2000);
        setTimeout(function() {
            var unique_id = $.gritter.add({
                title: 'Buy Metronic!',
                text: 'Metronic comes with a huge collection of reusable and easy customizable UI components and plugins. Buy Metronic today!',
                image: './assets/img/avatar1.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            setTimeout(function() {
                $.gritter.remove(unique_id, {
                    fade: true,
                    speed: 'slow'
                });
            }, 13000);
        }, 8000);
        setTimeout(function() {
            $('#styler').pulsate({
                color: "#bb3319",
                repeat: 10
            });
            $.extend($.gritter.options, {
                position: 'top-left'
            });
            var unique_id = $.gritter.add({
                position: 'top-left',
                title: 'Customize Metronic!',
                text: 'Metronic allows you to easily customize the theme colors and layout settings.',
                image1: './assets/img/avatar1.png',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            $.extend($.gritter.options, {
                position: 'top-right'
            });
            setTimeout(function() {
                $.gritter.remove(unique_id, {
                    fade: true,
                    speed: 'slow'
                });
            }, 15000);
        }, 23000);
        setTimeout(function() {
            $.extend($.gritter.options, {
                position: 'top-left'
            });
            var unique_id = $.gritter.add({
                title: 'Notification',
                text: 'You have 3 new notifications.',
                image1: './assets/img/image1.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            setTimeout(function() {
                $.gritter.remove(unique_id, {
                    fade: true,
                    speed: 'slow'
                });
            }, 4000);
            $.extend($.gritter.options, {
                position: 'top-right'
            });
            var number = $('#header_notification_bar .badge').text();
            number = parseInt(number);
            number = number + 3;
            $('#header_notification_bar .badge').text(number);
            $('#header_notification_bar').pulsate({
                color: "#66bce6",
                repeat: 5
            });
        }, 40000);
        setTimeout(function() {
            $.extend($.gritter.options, {
                position: 'top-left'
            });
            var unique_id = $.gritter.add({
                title: 'Inbox',
                text: 'You have 2 new messages in your inbox.',
                image1: './assets/img/avatar1.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            $.extend($.gritter.options, {
                position: 'top-right'
            });
            setTimeout(function() {
                $.gritter.remove(unique_id, {
                    fade: true,
                    speed: 'slow'
                });
            }, 4000);
            var number = $('#header_inbox_bar .badge').text();
            number = parseInt(number);
            number = number + 2;
            $('#header_inbox_bar .badge').text(number);
            $('#header_inbox_bar').pulsate({
                color: "#dd5131",
                repeat: 5
            });
        }, 60000);
    }
    var handleGritterNotifications = function() {
        if (!jQuery.gritter) {
            return;
        }
        $('#gritter-sticky').click(function() {
            var unique_id = $.gritter.add({
                title: 'This is a sticky notice!',
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
                image: './assets/img/avatar1.jpg',
                sticky: true,
                time: '',
                class_name: 'my-sticky-class'
            });
            return false;
        });
        $('#gritter-regular').click(function() {
            $.gritter.add({
                title: 'This is a regular notice!',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
                image: './assets/img/avatar1.jpg',
                sticky: false,
                time: ''
            });
            return false;
        });
        $('#gritter-max').click(function() {
            $.gritter.add({
                title: 'This is a notice with a max of 3 on screen at one time!',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
                image: './assets/img/avatar1.jpg',
                sticky: false,
                before_open: function() {
                    if ($('.gritter-item-wrapper').length == 3) {
                        return false;
                    }
                }
            });
            return false;
        });
        $('#gritter-without-image').click(function() {
            $.gritter.add({
                title: 'This is a notice without an image!',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.'
            });
            return false;
        });
        $('#gritter-light').click(function() {
            $.gritter.add({
                title: 'This is a light notification',
                text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
                class_name: 'gritter-light'
            });
            return false;
        });
        $("#gritter-remove-all").click(function() {
            $.gritter.removeAll();
            return false;
        });
    }
    var handleTooltip = function() {
        if (App.isTouchDevice()) {
            jQuery('.tooltips:not(.no-tooltip-on-touch-device)').tooltip();
        } else {
            jQuery('.tooltips').tooltip();
        }
    }
    var handlePopover = function() {
        jQuery('.popovers').popover();
    }
    var handleChoosenSelect = function() {
        if (!jQuery().chosen) {
            return;
        }

        $(".chosen").chosen();
        $(".chosen-with-diselect").chosen({
            allow_single_deselect: true
        })
    }
    var initChosenSelect = function(els) {
        $(els).chosen({
            allow_single_deselect: true
        })
    }
    var handleUniform = function() {
        if (!jQuery().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
        if (test) {
            test.uniform();
        }
    }
    var initUniform = function(els) {
        jQuery(els).each(function() {
            if ($(this).parents(".checker").size() == 0) {
                $(this).show();
                $(this).uniform();
            }
        });
    }
    var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            return;
        }
        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5();
        }
    }
    var handleToggleButtons = function() {
        if (!jQuery().toggleButtons) {
            return;
        }
        $('.basic-toggle-button').toggleButtons();
        $('.text-toggle-button').toggleButtons({
            width: 200,
            label: {
                enabled: "Lorem Ipsum",
                disabled: "Dolor Sit"
            }
        });
        $('.danger-toggle-button').toggleButtons({
            style: {
                enabled: "danger",
                disabled: "info"
            }
        });
        $('.info-toggle-button').toggleButtons({
            style: {
                enabled: "info",
                disabled: ""
            }
        });
        $('.success-toggle-button').toggleButtons({
            style: {
                enabled: "success",
                disabled: "info"
            }
        });
        $('.warning-toggle-button').toggleButtons({
            style: {
                enabled: "warning",
                disabled: "info"
            }
        });
        $('.height-toggle-button').toggleButtons({
            height: 100,
            font: {
                'line-height': '100px',
                'font-size': '20px',
                'font-style': 'italic'
            }
        });
    }
    var handleTables = function() {
        if (!jQuery().dataTable) {
            return;
        }
        $('#sample_1').dataTable({
            "aLengthMenu": [
                [5, 10, 15, 20, 50, 100, -1],
                [5, 10, 15, 20, 50, 100, "All"]
            ],
            "iDisplayLength": 50,
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
        jQuery('#sample_1 .group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
        jQuery('#sample_1_wrapper .dataTables_filter input').addClass("m-wrap medium");
        jQuery('#sample_1_wrapper .dataTables_length select').addClass("m-wrap xsmall");
        $('#sample_2').dataTable({
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
        jQuery('#sample_2 .group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
        jQuery('#sample_2_wrapper .dataTables_filter input').addClass("m-wrap small");
        jQuery('#sample_2_wrapper .dataTables_length select').addClass("m-wrap xsmall");
        $('#sample_3').dataTable({
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
        jQuery('#sample_3 .group-checkable').change(function() {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function() {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
        jQuery('#sample_3_wrapper .dataTables_filter input').addClass("m-wrap small");
        jQuery('#sample_3_wrapper .dataTables_length select').addClass("m-wrap xsmall");
    }
    var handleEditableTables = function() {
        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }
            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[3] + '">';
            jqTds[4].innerHTML = '<a class="edit" href="">Save</a>';
            jqTds[5].innerHTML = '<a class="cancel" href="">Cancel</a>';
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
            oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 5, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
            oTable.fnDraw();
        }
        var oTable = $('#sample_editable_1').dataTable();
        jQuery('#sample_editable_1_wrapper .dataTables_filter input').addClass("m-wrap medium");
        jQuery('#sample_editable_1_wrapper .dataTables_length select').addClass("m-wrap xsmall");
        var nEditing = null;
        $('#sample_editable_1_new').click(function(e) {
            e.preventDefault();
            var aiNew = oTable.fnAddData(['', '', '', '', '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
        });
        $('#sample_editable_1 a.delete').live('click', function(e) {
            e.preventDefault();
            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }
            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
            alert("Deleted! Do not forget to do some ajax to sync with backend :)");
        });
        $('#sample_editable_1 a.cancel').live('click', function(e) {
            e.preventDefault();
            if ($(this).attr("data-mode") == "new") {
                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });
        $('#sample_editable_1 a.edit').live('click', function(e) {
            e.preventDefault();
            var nRow = $(this).parents('tr')[0];
            if (nEditing !== null && nEditing != nRow) {
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                saveRow(oTable, nEditing);
                nEditing = null;
                alert("Updated! Do not forget to do some ajax to sync with backend :)");
            } else {
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }
    var handleTagsInput = function() {
        if (!jQuery().tagsInput) {
            return;
        }
        $('#tags_1').tagsInput({
            width: 'auto',
            'onAddTag': function() {
                alert(1);
            },
        });
        $('#tags_2').tagsInput({
            width: 240
        });
    }
    var handleDateTimePickers = function() {
        if (jQuery().datepicker) {
            $('.date-picker').datepicker();
        }
        if (jQuery().timepicker) {
            $('.timepicker-default').timepicker();
            $('.timepicker-24').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        }
        if (!jQuery().daterangepicker) {
            return;
        }
        $('.date-range').daterangepicker();
        $('#dashboard-report-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                    days: -6
                }), 'today'],
                'Last 30 Days': [Date.today().add({
                    days: -29
                }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                    months: -1
                }), Date.today().moveToFirstDayOfMonth().add({
                    days: -1
                })]
            },
            opens: 'left',
            format: 'dd-MM-yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -29
            }),
            endDate: Date.today(),
            minDate: '01-01-2012',
            maxDate: '31-12-2014',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        }, function(start, end) {
            App.blockUI(jQuery("#dashboard"));
            setTimeout(function() {
                App.unblockUI(jQuery("#dashboard"));
                $.gritter.add({
                    title: 'Dashboard',
                    text: 'Dashboard date range updated.'
                });
                App.scrollTo();
            }, 1000);
            $('#dashboard-report-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
        });
        $('#dashboard-report-range').show();
        $('#dashboard-report-range span').html(Date.today().add({
            days: -29
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));
        $('#form-date-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                    days: -6
                }), 'today'],
                'Last 30 Days': [Date.today().add({
                    days: -29
                }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                    months: -1
                }), Date.today().moveToFirstDayOfMonth().add({
                    days: -1
                })]
            },
            opens: 'left',
            format: 'dd-MM-yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -29
            }),
            endDate: Date.today(),
            minDate: '01-01-2012',
            maxDate: '31-12-2014',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        }, function(start, end) {
            $('#form-date-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
            $('#date-range').val(start.toString('yyyy-MM-dd') + ' / ' + end.toString('yyyy-MM-dd'));
        });
        if (!jQuery().datepicker || !jQuery().timepicker) {
            return;
        }
    }
    var handleClockfaceTimePickers = function() {
        if (!jQuery().clockface) {
            return;
        }
        $('#clockface_1').clockface();
        $('#clockface_2').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });
        $('#clockface_2_toggle-btn').click(function(e) {
            e.stopPropagation();
            $('#clockface_2').clockface('toggle');
        });
        $('#clockface_3').clockface({
            format: 'H:mm'
        }).clockface('show', '14:30');
    }
    var handleColorPicker = function() {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
    }
    var handleAccordions = function() {
        $(".accordion").collapse().height('auto');
        var lastClicked;
        jQuery('.accordion.scrollable .accordion-toggle').click(function() {
            lastClicked = jQuery(this);
        });
        jQuery('.accordion.scrollable').on('shown', function() {
            jQuery('html,body').animate({
                scrollTop: lastClicked.offset().top - 150
            }, 'slow');
        });
    }
    var handleScrollers = function() {
        var setPageScroller = function() {
            $('.main').slimScroll({
                size: '12px',
                color: '#a1b2bd',
                height: $(window).height(),
                allowPageScroll: true,
                alwaysVisible: true,
                railVisible: true
            });
        }
        $('.scroller').each(function() {
            $(this).slimScroll({
                size: '7px',
                color: '#a1b2bd',
                height: $(this).attr("data-height"),
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                disableFadeOut: true
            });
        });
    }
    var handleSliders = function() {
        $(".slider-basic").slider();
        $("#slider-snap-inc").slider({
            value: 100,
            min: 0,
            max: 1000,
            step: 100,
            slide: function(event, ui) {
                $("#slider-snap-inc-amount").text("$" + ui.value);
            }
        });
        $("#slider-snap-inc-amount").text("$" + $("#slider-snap-inc").slider("value"));
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [75, 300],
            slide: function(event, ui) {
                $("#slider-range-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#slider-range-amount").text("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
        $("#slider-range-max").slider({
            range: "max",
            min: 1,
            max: 10,
            value: 2,
            slide: function(event, ui) {
                $("#slider-range-max-amount").text(ui.value);
            }
        });
        $("#slider-range-max-amount").text($("#slider-range-max").slider("value"));
        $("#slider-range-min").slider({
            range: "min",
            value: 37,
            min: 1,
            max: 700,
            slide: function(event, ui) {
                $("#slider-range-min-amount").text("$" + ui.value);
            }
        });
        $("#slider-range-min-amount").text("$" + $("#slider-range-min").slider("value"));
        $("#slider-eq > span").each(function() {
            var value = parseInt($(this).text(), 10);
            $(this).empty().slider({
                value: value,
                range: "min",
                animate: true,
                orientation: "vertical"
            });
        });
        $("#slider-vertical").slider({
            orientation: "vertical",
            range: "min",
            min: 0,
            max: 100,
            value: 60,
            slide: function(event, ui) {
                $("#slider-vertical-amount").text(ui.value);
            }
        });
        $("#slider-vertical-amount").text($("#slider-vertical").slider("value"));
        $("#slider-range-vertical").slider({
            orientation: "vertical",
            range: true,
            values: [17, 67],
            slide: function(event, ui) {
                $("#slider-range-vertical-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#slider-range-vertical-amount").text("$" + $("#slider-range-vertical").slider("values", 0) + " - $" + $("#slider-range-vertical").slider("values", 1));
    }
    var handlKnobElements = function() {
        if (!jQuery().knob || isIE8) {
            return;
        }
        $(".knob").knob({
            'dynamicDraw': true,
            'thickness': 0.2,
            'tickColorizeValues': true,
            'skin': 'tron'
        });
        if ($(".knobify").size() > 0) {
            $(".knobify").knob({
                readOnly: true,
                skin: "tron",
                'width': 100,
                'height': 100,
                'dynamicDraw': true,
                'thickness': 0.2,
                'tickColorizeValues': true,
                'skin': 'tron',
                draw: function() {
                    if (this.$.data('skin') == 'tron') {
                        var a = this.angle(this.cv),
                            sa = this.startAngle,
                            sat = this.startAngle,
                            ea, eat = sat + a,
                            r = 1;
                        this.g.lineWidth = this.lineWidth;
                        this.o.cursor && (sat = eat - 0.3) && (eat = eat + 0.3);
                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.v);
                            this.o.cursor && (sa = ea - 0.3) && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }
                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();
                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();
                        return false;
                    }
                }
            });
        }
    }
    var handleGoTop = function() {
        jQuery('.footer .go-top').click(function() {
            App.scrollTo();
        });
    }
    var handleChat = function() {
        var cont = $('#chats');
        var list = $('.chats', cont);
        var form = $('.chat-form', cont);
        var input = $('input', form);
        var btn = $('.btn', form);
        var handleClick = function() {
            var text = input.val();
            if (text.length == 0) {
                return;
            }
            var time = new Date();
            var time_str = time.toString('MMM dd, yyyy HH:MM');
            var tpl = '';
            tpl += '<li class="out">';
            tpl += '<img class="avatar" alt="" src="assets/img/avatar1.jpg"/>';
            tpl += '<div class="message">';
            tpl += '<span class="arrow"></span>';
            tpl += '<a href="#" class="name">Bob Nilson</a>&nbsp;';
            tpl += '<span class="datetime">at ' + time_str + '</span>';
            tpl += '<span class="body">';
            tpl += text;
            tpl += '</span>';
            tpl += '</div>';
            tpl += '</li>';
            var msg = list.append(tpl);
            input.val("");
            $('.scroller', cont).slimScroll({
                scrollTo: list.height()
            });
        }
        btn.click(handleClick);
        input.keypress(function(e) {
            if (e.which == 13) {
                handleClick();
                return false;
            }
        });
    }
    var handleNestableList = function() {
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        $('#nestable_list_1').nestable({
            group: 1
        }).on('change', updateOutput);
        $('#nestable_list_2').nestable({
            group: 1
        }).on('change', updateOutput);
        updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));
        updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));
        $('#nestable_list_menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
        $('#nestable_list_3').nestable();
    }
    var handleStyler = function() {
        var panel = $('.color-panel');
        $('.icon-color', panel).click(function() {
            $('.color-mode').show();
            $('.icon-color-close').show();
        });
        $('.icon-color-close', panel).click(function() {
            $('.color-mode').hide();
            $('.icon-color-close').hide();
        });
        $('li', panel).click(function() {
            var color = $(this).attr("data-style");
            setColor(color);
            $('.inline li', panel).removeClass("current");
            $(this).addClass("current");
        });
        $('input', panel).change(function() {
            setLayout();
        });
        var setColor = function(color) {
            $('#style_color').attr("href", "assets/css/style_" + color + ".css");
        }
        var setLayout = function() {
            if ($('input.header', panel).is(":checked")) {
                $("body").addClass("fixed-top");
                $(".header").addClass("navbar-fixed-top");
            } else {
                $("body").removeClass("fixed-top");
                $(".header").removeClass("navbar-fixed-top");
            }
        }
    }
    var handleFormWizards = function() {
        if (!jQuery().bootstrapWizard) {
            return;
        }
        $('#form_wizard_1').bootstrapWizard({
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            onTabClick: function(tab, navigation, index) {
                alert('on tab click disabled');
                return false;
            },
            onNext: function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }
                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }
                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            },
            onPrevious: function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }
                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }
                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            },
            onTabShow: function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                var $percent = (current / total) * 100;
                $('#form_wizard_1').find('.bar').css({
                    width: $percent + '%'
                });
            }
        });
        $('#form_wizard_1').find('.button-previous').hide();
        $('#form_wizard_1 .button-submit').click(function() {
            alert('Finished! Hope you like it :)');
        }).hide();
    }
    var handleFormValidation = function() {
        var form1 = $('#form_sample_1');
        var error1 = $('.alert-error', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                digits: {
                    required: true,
                    digits: true
                },
                creditcard: {
                    required: true,
                    creditcard: true
                },
                occupation: {
                    minlength: 5,
                },
                category: {
                    required: true
                }
            },
            invalidHandler: function(event, validator) {
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
            },
            submitHandler: function(form) {
                success1.show();
                error1.hide();
            }
        });
        var form2 = $('#form_sample_2');
        var error2 = $('.alert-error', form2);
        var success2 = $('.alert-success', form2);
        form2.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                category: {
                    required: true
                },
                education: {
                    required: true
                },
                occupation: {
                    minlength: 5,
                },
                membership: {
                    required: true
                },
                service: {
                    required: true,
                    minlength: 2
                },
                fItemCatName: {
                    required: true,
                    minlength: 2
                },
                fItemCatDesc: {
                    required: true,
                    minlength: 2
                },
                fAssetUnitName: {
                    required: true,
                    minlength: 2
                },
                fAssetUnitDesc: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                membership: {
                    required: "Please select a Membership type"
                },
                fItemCatName: {
                    required: "Please Enter the item Name"
                },
                fItemCatDesc: {
                    required: "Please Enter the item Description"
                },
                fAssetUnitName: {
                    required: "Please Enter the Unit Name"
                },
                fAssetUnitDesc: {
                    required: "Please Enter the Unit Description"
                },
                service: {
                    required: "Please select  at least 2 types of Service",
                    minlength: jQuery.format("Please select  at least {0} types of Service")
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "education") {
                    error.insertAfter("#form_2_education_chzn");
                } else if (element.attr("name") == "membership") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else if (element.attr("name") == "service") {
                    error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                success2.hide();
                error2.show();
                App.scrollTo(error2, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                success2.show();
                error2.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', form2).change(function() {
            form2.validate().element($(this));
        });
	
		
		
        var assettypeform = $('#assettype');
        var typeerror = $('.alert-error', assettypeform);
        var typesuccess = $('.alert-success', assettypeform);
        assettypeform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetTypeName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fAssetTypeName: {
                    required: "Please Enter the Asset Type Name"
                },
                fLookup: {
                    required: "Please Enter the Asset Lookup"
                },
                fStatus: {
                    required: "Please select a status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                typesuccess.hide();
                typeerror.show();
                App.scrollTo(typeerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                typesuccess.show();
                typeerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', assettypeform).change(function() {
            assettypeform.validate().element($(this));
        });
        var group1form = $('#group1');
        var group1error = $('.alert-error', group1form);
        var group1success = $('.alert-success', group1form);
        group1form.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fItemGroup1Name: {
                    required: true
                },
                fStatus: {
                    required: true
                }
            },
            messages: {
                fItemGroup1Name: {
                    required: "Please Enter the Item Group 1 Name"
                },
                fStatus: {
                    required: "Please select a status"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                group1success.hide();
                group1error.show();
                App.scrollTo(group1error, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                group1success.show();
                group1error.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', group1form).change(function() {
            group1form.validate().element($(this));
        });
        var contractform = $('#form_contract');
        var contracterror = $('.alert-error', contractform);
        var contractsuccess = $('.alert-success', contractform);
        contractform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            rules: {
                fContractTitle: {
                    required: true
                }
            },
            messages: {
                fContractTitle: {
                    required: "Please Enter the Item Group 1 Name"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                contractsuccess.hide();
                contracterror.show();
                App.scrollTo(group1error, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                contractsuccess.show();
                contracterror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', contractform).change(function() {
            contractform.validate().element($(this));
        });
        var countryaddnewform = $('#form_country_addnew');
        var countryaddnewerror = $('.alert-error', countryaddnewform);
        var countryaddnewsuccess = $('.alert-success', countryaddnewform);
        countryaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fCountryName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fCurrency: {
                    required: true
                },
                fCurrencyCode: {
                    required: true

                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fCountryName: {
                    required: "Please Enter the Country Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fCurrency: {
                    required: "Please Enter the Currency"
                },
                fCurrencyCode: {
                    required: "Please Enter the Country Code"
                },
                fStatus: {
                    required: "Please select a status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                countryaddnewsuccess.hide();
                countryaddnewerror.show();
                App.scrollTo(countryaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                countryaddnewsuccess.show();
                countryaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', countryaddnewform).change(function() {
            countryaddnewform.validate().element($(this));
        });
        var currencyaddnewform = $('#form_currency_addnew');
        var currencyaddnewerror = $('.alert-error', currencyaddnewform);
        var currencyaddnewsuccess = $('.alert-success', currencyaddnewform);
        currencyaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fCurrencyName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fCurrencyName: {
                    required: "Please Enter the Currency Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fStatus: {
                    required: "Please select a status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                currencyaddnewsuccess.hide();
                currencyaddnewerror.show();
                App.scrollTo(currencyaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                currencyaddnewsuccess.show();
                currencyaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', currencyaddnewform).change(function() {
            currencyaddnewform.validate().element($(this));
        });
        var stateaddnewform = $('#form_state_addnew');
        var stateaddnewerror = $('.alert-error', stateaddnewform);
        var stateaddnewsuccess = $('.alert-success', stateaddnewform);
        stateaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fStateName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fStatus: {
                    required: true
                },
                fCountryId: {
                    required: true
                }
            },
            messages: {
                fStateName: {
                    required: "Please Enter the State Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fStatus: {
                    required: "Please select a status"
                },
                fCountryId: {
                    required: "Please select a Country"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                stateaddnewsuccess.hide();
                stateaddnewerror.show();
                App.scrollTo(stateaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                stateaddnewsuccess.show();
                stateaddnewerror.hide();
                form.submit();
            }
        });
		  var poaddnewform = $('#form_pos');
        var poaddnewerror = $('.alert-error', poaddnewform);
        var poaddnewsuccess = $('.alert-success', poaddnewform);
		poaddnewform.validate({
			 errorElement: 'span',
            errorClass: 'help-inline',
            rules: { 
			      fUnitId:{
					required: true,
					},
					fDepartmentId:{
					required: false,
					},
					
					fvendorId:{
					required: true,
					},
					fShippingId:{
					required: true,
					},
					fDuedate:{
					required: true,
					}
	 },
	 messages: {
               
            },
            errorPlacement: function(error, element) {
               
                    error.insertAfter(element);
               
            },
            invalidHandler: function(event, validator) {
                poaddnewsuccess.hide();
                poaddnewerror.show();
                App.scrollTo(poaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
	        submitHandler: function(form) {
             poaddnewsuccess.show();
             poaddnewerror.hide();
			 amsPopup();
			 form.submit();
            }
	
	  }); 
	 $('.chosen ', poaddnewform).change(function() {
           poaddnewform.validate().element($(this));
        });
    var assetitemaddnewform = $('#from_grn');
        var assetitemaddnewerror = $('.alert-error', assetitemaddnewform);
        var assetitemaddnewsuccess = $('.alert-success', assetitemaddnewform);
		assetitemaddnewform.validate({
			 errorElement: 'span',
            errorClass: 'help-inline',
			 focusInvalid: false,
            ignore: "",
            rules: { 
			      fDcNumber:{
					required: true,
					},
					fDcDate:{
					required: true,
					},
					
					fVendorId:{
					required: true,
					},
					fStoreId:{
					required: true,
					},
					fPOId:{
					required: true,
					}
	 },
	 messages: {
               
            },
            errorPlacement: function(error, element) {
               
                    error.insertAfter(element);
               
            },
            invalidHandler: function(event, validator) {
                assetitemaddnewsuccess.hide();
                assetitemaddnewerror.show();
                App.scrollTo(assetitemaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
	        submitHandler: function(form) {
             assetitemaddnewsuccess.show();
             assetitemaddnewerror.hide();
			 amsPopup();
			 form.submit();
            }
	
	  }); 
	
		
        var cityaddnewform = $('#form_city_addnew');
        var cityaddnewerror = $('.alert-error', cityaddnewform);
        var cityaddnewsuccess = $('.alert-success', cityaddnewform);
        cityaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fCityName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fCityName: {
                    required: "Please Enter the City Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fStatus: {
                    required: "Please select a status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                cityaddnewsuccess.hide();
                cityaddnewerror.show();
                App.scrollTo(cityaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                cityaddnewsuccess.show();
                cityaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', cityaddnewform).change(function() {
            cityaddnewform.validate().element($(this));
        });
        var companyaddnewform = $('#form_company_addnew');
        var companyaddnewerror = $('.alert-error', companyaddnewform);
        var companyaddnewsuccess = $('.alert-success', companyaddnewform);
        companyaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fCompanyName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fAddr1: {
                    required: true
                },
                fAddr2: {
                    required: true
                },
                fZipCode: {
                    required: true
                },
                fPhone: {
                    required: true
                },
                fFax: {
                    required: true
                },
                fEmail: {
                    required: true,
                    email: true
                },
                fTinNo: {
                    required: true
                },
                fCstNoDate: {
                    required: true
                },
            },
            messages: {
                fCompanyName: {
                    required: "Please Enter the Company Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fAddr1: {
                    required: "Please Enter the Address 1"
                },
                fAddr2: {
                    required: "Please Enter the Address 2"
                },
                fAddr3: {
                    required: "Please Enter the Address 3"
                },
                fZipCode: {
                    required: "Please Enter the Pincode"
                },
                fPhone: {
                    required: "Please Enter the Telephone Number"
                },
                fFax: {
                    required: "Please Enter the Fax"
                },
                fEmail: {
                    required: "Please Enter the Email"
                },
                fTinNo: {
                    required: "Please Enter the Tin No"
                },
                fCstNoDate: {
                    required: "Please Enter the CST No/Date "
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                companyaddnewsuccess.hide();
                companyaddnewerror.show();
                App.scrollTo(companyaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                companyaddnewsuccess.show();
                companyaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', companyaddnewform).change(function() {
            companyaddnewform.validate().element($(this));
        });
        var divisionaddnewform = $('#form_division_addnew');
        var divisionaddnewerror = $('.alert-error', divisionaddnewform);
        var divisionaddnewsuccess = $('.alert-success', divisionaddnewform);
        divisionaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fDivisionName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
            },
            messages: {
                fDivisionName: {
                    required: "Please Enter the Division Name"

                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                divisionaddnewsuccess.hide();
                divisionaddnewerror.show();
                App.scrollTo(divisionaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                divisionaddnewsuccess.show();
                divisionaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', divisionaddnewform).change(function() {
            divisionaddnewform.validate().element($(this));
        });
        var storeaddnewform = $('#form_store_addnew');
        var storeaddnewerror = $('.alert-error', storeaddnewform);
        var storeaddnewsuccess = $('.alert-success', storeaddnewform);
        storeaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fStoreName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
            },
            messages: {
                fStoreName: {
                    required: "Please Enter the Store Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                storeaddnewsuccess.hide();
                storeaddnewerror.show();
                App.scrollTo(storeaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();

                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                storeaddnewsuccess.show();
                storeaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', storeaddnewform).change(function() {
            storeaddnewform.validate().element($(this));
        });
        var unitaddnewform = $('#form_aunit_addnew');
        var unitaddnewerror = $('.alert-error', unitaddnewform);
        var unitaddnewsuccess = $('.alert-success', unitaddnewform);
        unitaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetUnitName: {
                    required: true
                },
                fAddr1: {
                    required: true
                },
                fAddr2: {
                    required: true
                },
                fZipCode: {
                    required: true
                },
                fCityId: {
                    selectcity: true
                },
                fStateId: {
                    selectstate: true
                },
                fCountryId: {
                    selectcountry: true
                },
                fPhone: {
                    required: true
                },
            },
            messages: {
                fAssetUnitName: {
                    required: "Please Enter the Unit Name"
                },
                fAddr1: {
                    required: "Please Enter the Unit Address1"
                },
                fAddr2: {
                    required: "Please Enter the Unit Address2"
                },
                fZipCode: {
                    required: "Please Enter the Unit Pincode"
                },
                fPhone: {
                    required: "Please Enter the Unit Phone"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                unitaddnewsuccess.hide();
                unitaddnewerror.show();
                App.scrollTo(unitaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                unitaddnewsuccess.show();
                unitaddnewerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selectcity', function(value) {
            return (value != '0');
        }, "Please Select the City");
        $.validator.addMethod('selectstate', function(value) {
            return (value != '0');
        }, "Please Select the State");
        $.validator.addMethod('selectcountry', function(value) {
            return (value != '0');
        }, "Please Select the Country");
        $('.chosen, .chosen-with-diselect', unitaddnewform).change(function() {
            unitaddnewform.validate().element($(this));
        });
        var supplieraddnewform = $('#form_supplier_addnew');
        var supplieraddnewerror = $('.alert-error', supplieraddnewform);
        var supplieraddnewsuccess = $('.alert-success', supplieraddnewform);
        supplieraddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fVendorName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fAddr1: {
                    required: true
                },
                fAddr2: {
                    required: true
                },
                fZipCode: {
                    required: true
                },
                fCityId: {
                    selectvcity: true
                },
                fStateId: {
                    selectvstate: true
                },
                fCountryId: {
                    selectvcountry: true
                },
                fPhone: {
                    required: true
                },
                fContactName: {
                    required: true
                },
                "fVendorGroupId[]": "required"
            },
            messages: {
                fVendorName: {
                    required: "Please Enter Vendor name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fAddr1: {
                    required: "Please Enter Vendor Address1"
                },
                fAddr2: {
                    required: "Please Enter Vendor Address2"
                },
                fZipCode: {
                    required: "Please Enter Vendor Pincode"
                },
                fPhone: {
                    required: "Please Enter Vendor Phone"
                },
                fContactName: {
                    required: "Please Enter Vendor Contact Person"
                },
                "fVendorGroupId[]": "Please Select Vendor Groups"
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                supplieraddnewsuccess.hide();
                supplieraddnewerror.show();
                App.scrollTo(supplieraddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                supplieraddnewsuccess.show();
                supplieraddnewerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selectvcity', function(value) {
            return (value != '0');
        }, "Please Select Vendor City");
        $.validator.addMethod('selectvstate', function(value) {
            return (value != '0');
        }, "Please Select Vendor State");
        $.validator.addMethod('selectvcountry', function(value) {
            return (value != '0');
        }, "Please Select Vendor Country");
        $('.chosen, .chosen-with-diselect', supplieraddnewform).change(function() {
            supplieraddnewform.validate().element($(this));
        });
        var contactaddnewform = $('#form_contact_addnew');
        var contactaddnewerror = $('.alert-error', contactaddnewform);
        var contactaddnewsuccess = $('.alert-success', contactaddnewform);
        contactaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fContactName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fAddr1: {
                    required: true
                },
                fAddr2: {
                    required: true
                },
                fZipCode: {
                    required: true
                },
                fCityId: {
                    selectvcity: true
                },
                fStateId: {
                    selectvstate: true
                },
                fCountryId: {
                    selectvcountry: true
                },
                fPhone: {
                    required: true
                },
                fContactName: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fContactName: {
                    required: "Please Enter Vendor Contact Person"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fAddr1: {
                    required: "Please Enter Vendor Address1"
                },
                fAddr2: {
                    required: "Please Enter Vendor Address2"
                },
                fZipCode: {
                    required: "Please Enter Vendor Pincode"
                },
                fPhone: {
                    required: "Please Enter Vendor Phone"
                },
                fStatus: {
                    required: "Please Select the Status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                contactaddnewerror.hide();
                contactaddnewerror.show();
                App.scrollTo(contactaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                contactaddnewsuccess.show();
                contactaddnewerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selectvcity', function(value) {
            return (value != '0');
        }, "Please Select Vendor City");
        $.validator.addMethod('selectvstate', function(value) {
            return (value != '0');
        }, "Please Select Vendor State");
        $.validator.addMethod('selectvcountry', function(value) {
            return (value != '0');
        }, "Please Select Vendor Country");
        $('.chosen, .chosen-with-diselect', contactaddnewform).change(function() {
            contactaddnewform.validate().element($(this));
        });
        var employeeaddnewform = $('#form_employee_addnew');
        var employeeaddnewerror = $('.alert-error', employeeaddnewform);
        var employeeaddnewsuccess = $('.alert-success', employeeaddnewform);
        employeeaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fPrefix: {
                    selecteprefix: true
                },
                fEmployeeFirstName: {
                    required: true
                },
                fEmployeeLastName: {
                    required: true
                },
                fAddr1: {
                    required: true
                },
                fAddr2: {
                    required: true
                },
                fCityId: {
                    selectcity: true
                },
                fStateId: {
                    selectstate: true
                },
                fCountryId: {
                    selectcountry: true
                },
                fZipCode: {
                    required: true
                },
                fPhone: {
                    required: true
                },
                fEmployeeType: {
                    selectetype: true
                },
                fEmployeeCategory: {
                    selectecategory: true
                },
                fCompanyId: {
                    selectecompany: true
                },
                fUnitId: {
                    selectecompany: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fEmployeeFirstName: {
                    required: "Please Enter Employee First name"
                },
                fEmployeeLastName: {
                    required: "Enter Employee Last name"
                },
                fAddr1: {
                    required: "Please Enter Address Line"
                },
                fAddr2: {
                    required: "Please Enter Address Line"
                },
                fCityId: {
                    required: "Please Select City"
                },
                fStateId: {
                    required: "Please Select State"
                },
                fCountryId: {
                    required: "Please Select Country"
                },
                fZipCode: {
                    required: "Please Enter Pincode"
                },
                fPhone: {
                    required: "Please Enter Phone"
                },
                fStatus: {
                    required: "Please Select the Status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                employeeaddnewsuccess.hide();
                employeeaddnewerror.show();
                App.scrollTo(employeeaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                employeeaddnewsuccess.show();
                employeeaddnewerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selecteprefix', function(value) {
            return (value != '0');
        }, "Please Select Prefix");
        $.validator.addMethod('selectetype', function(value) {
            return (value != '0');
        }, "Please Select Employee Type");
        $.validator.addMethod('selectecategory', function(value) {
            return (value != '0');
        }, "Please Select Employee Category");
        $.validator.addMethod('selectecompany', function(value) {
            return (value != '0');
        }, "Please Select Employee Company");
        $.validator.addMethod('selectcity', function(value) {
            return (value != '0');
        }, "Please Select the City");
        $.validator.addMethod('selectstate', function(value) {
            return (value != '0');
        }, "Please Select the State");
        $.validator.addMethod('selectcountry', function(value) {
            return (value != '0');
        }, "Please Select the Country");
        $.validator.addMethod('selectunit', function(value) {
            return (value != '0');
        }, "Please Select the Unit");
        $('.chosen, .chosen-with-diselect', employeeaddnewform).change(function() {
            employeeaddnewform.validate().element($(this));
        });
        var purchaserqcreateform = $('#form_purchaserequest_edit');
        var purchaserqcreateerror = $('.alert-error', purchaserqcreateform);
        var purchaserqcreatesuccess = $('.alert-success', purchaserqcreateform);
        purchaserqcreateform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fUnitId: {
                    selectunitid: true
                },
                fDepartmentId: {
                    selectdeptid: true
                },
                fVendorId: {
                    selectvendorid: true
                },
                fEmployeeId: {
                    selectemployid: true
                }
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                purchaserqcreatesuccess.hide();
                purchaserqcreateerror.show();
                App.scrollTo(purchaserqcreateerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                purchaserqcreatesuccess.show();
                purchaserqcreateerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selectunitid', function(value) {
            return (value != '0');
        }, "Please select Unit Id");
        $.validator.addMethod('selectdeptid', function(value) {
            return (value != '0');
        }, "Please Select Department Id");
        $.validator.addMethod('selectvendorid', function(value) {
            return (value != '0');
        }, "Please Select Vendor Id");
        $.validator.addMethod('selectemployid', function(value) {
            return (value != '0');
        }, "Please Select Employee Id");
        $.validator.addMethod('selectgroup1item', function(value) {
            return (value != '0');
        }, "Please Select Group1 Item");
        $.validator.addMethod('selectgroup2item', function(value) {
            return (value != '0');
        }, "Please Select Group2 Item");
        $.validator.addMethod('selectitemname', function(value) {
            return (value != '0');
        }, "Please Select Item Name");
        $('.chosen, .chosen-with-diselect', purchaserqcreateform).change(function() {
            purchaserqcreateform.validate().element($(this));
        });
        var taxaddnewform = $('#form_taxform_addnew');
        var taxaddnewerror = $('.alert-error', taxaddnewform);
        var taxaddnewsuccess = $('.alert-success', taxaddnewform);
        taxaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fTaxFormName: {
                    required: true
                },
                fAddLess: {
                    selectaddless: true
                },
                fTaxPercentage: {
                    required: true
                },
                fLookup: {
                    required: true
                },
            },
            messages: {
                fTaxFormName: {
                    required: "Please Enter Taxform Name"
                },
                fTaxPercentage: {
                    required: "Please Enter Tax Percentage"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                taxaddnewsuccess.hide();
                taxaddnewerror.show();
                App.scrollTo(taxaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                taxaddnewsuccess.show();
                taxaddnewerror.hide();
                form.submit();
            }
        });
        $.validator.addMethod('selectaddless', function(value) {
            return (value != '0');
        }, "Please Select Add/Less");
        $('.chosen, .chosen-with-diselect', taxaddnewform).change(function() {
            taxaddnewform.validate().element($(this));
        });
        var uomaddnewform = $('#form_uom_addnew');
        var uomaddnewerror = $('.alert-error', uomaddnewform);
        var uomaddnewsuccess = $('.alert-success', uomaddnewform);
        uomaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fUomName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
            },
            messages: {
                fUomName: {
                    required: "Please Enter the UOM Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                uomaddnewsuccess.hide();
                uomaddnewerror.show();
                App.scrollTo(uomaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                uomaddnewsuccess.show();
                uomaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', uomaddnewform).change(function() {
            uomaddnewform.validate().element($(this));
        });
        var termsaddnewform = $('#form_terms_addnew');
        var termsaddnewerror = $('.alert-error', termsaddnewform);
        var termsaddnewsuccess = $('.alert-success', termsaddnewform);
        termsaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fTitle: {
                    required: true
                },
                fDescription: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fTitle: {
                    required: "Please Enter the Title"
                },
                fDescription: {
                    required: "Please Enter the Description"
                },
                fStatus: {
                    required: "Please Select the Status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                termsaddnewsuccess.hide();
                termsaddnewerror.show();
                App.scrollTo(termsaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                termsaddnewsuccess.show();
                termsaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', termsaddnewform).change(function() {
            termsaddnewform.validate().element($(this));
        });
        var vendortypeaddnewform = $('#form_vendortype_addnew');
        var vendortypeaddnewerror = $('.alert-error', vendortypeaddnewform);
        var vendortypeaddnewsuccess = $('.alert-success', vendortypeaddnewform);
        vendortypeaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fVendorTypeName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
            },
            messages: {
                fVendorTypeName: {
                    required: "Please Enter VendorType name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                vendortypeaddnewsuccess.hide();
                vendortypeaddnewerror.show();
                App.scrollTo(vendortypeaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                vendortypeaddnewsuccess.show();
                vendortypeaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', vendortypeaddnewform).change(function() {
            vendortypeaddnewform.validate().element($(this));
        });
        var fuellimitaddnewform = $('#form_fuellimit_addnew');
        var fuellinitaddnewerror = $('.alert-error', fuellimitaddnewform);
        var fuellimitaddnewsuccess = $('.alert-success', fuellimitaddnewform);
        fuellimitaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetNumber: {
                    required: true
                },
                fFuelLimit: {
                    required: true
                },
            },
            messages: {
                fAssetNumber: {
                    required: "Please Select AssetNumber"
                },
                fFuelLimit: {
                    required: "Please Enter the Fuel Limit"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                fuellimitaddnewsuccess.hide();
                fuellinitaddnewerror.show();
                App.scrollTo(fuellinitaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                fuellimitaddnewsuccess.show();
                fuellinitaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', fuellimitaddnewform).change(function() {
            fuellimitaddnewform.validate().element($(this));
        });
        var mainaddnewform = $('#form_maintenance');
        var mainaddnewerror = $('.alert-error', mainaddnewform);
        var mainaddnewsuccess = $('.alert-success', mainaddnewform);
        mainaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetNumber: {
                    required: true
                },
                fFromStoreId: {
                    required: true
                },
                fvendorId: {
                    required: true
                },
            },
            messages: {
                fAssetNumber: {
                    required: "Please Select Asset Number"
                },
                fFromStoreId: {
                    required: "Please Select Asset From Store"
                },
                fvendorId: {
                    required: "Please Select the Vendor"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                mainaddnewsuccess.hide();
                mainaddnewerror.show();
                App.scrollTo(mainaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                mainaddnewsuccess.show();
                mainaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', mainaddnewform).change(function() {
            mainaddnewform.validate().element($(this));
        });
        var manuaddnewform = $('#form_manufacturer');
        var manuaddnewerror = $('.alert-error', manuaddnewform);
        var manuaddnewsuccess = $('.alert-success', manuaddnewform);
        manuaddnewform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fManufacturerName: {
                    required: true
                },
                fLookup: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fManufacturerName: {
                    required: "Please Enter Manufacturer Name"
                },
                fLookup: {
                    required: "Please Enter the Lookup"
                },
                fStatus: {
                    required: "Please Select the Status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                manuaddnewsuccess.hide();
                manuaddnewerror.show();
                App.scrollTo(manuaddnewerror, -200);
                $('div.loading').addClass("disabled");
                $('div.loading').removeClass("enabled");
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                manuaddnewsuccess.show();
                manuaddnewerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', manuaddnewform).change(function() {
            manuaddnewform.validate().element($(this));
        });
        var roleform = $('#roleform');
        var roleerror = $('.alert-error', roleform);
        var rolesuccess = $('.alert-success', roleform);
        roleform.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fRoleName: {
                    required: true
                },
                fStatus: {
                    required: true
                },
            },
            messages: {
                fRoleName: {
                    required: "Please Enter the Role Name"
                },
                fStatus: {
                    required: "Please select a status"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "fStatus") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                rolesuccess.hide();
                roleerror.show();
                App.scrollTo(roleerror, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                rolesuccess.show();
                roleerror.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', roleform).change(function() {
            roleform.validate().element($(this));
        });
        var form3 = $('#form_sample_3');
        var error3 = $('.alert-error', form3);
        var success3 = $('.alert-success', form3);
        form3.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetUnitName: {
                    required: true,
                    minlength: 2
                },
                fAssetUnitDesc: {
                    required: true,
                    minlength: 2
                },
                fBuildingName: {
                    required: true,
                    minlength: 2
                },
                fBuildingDesc: {
                    required: true,
                    minlength: 2
                },
                fDepartmentName: {
                    required: true,
                    minlength: 2
                },
                fDepartmentDesc: {
                    required: true,
                    minlength: 2
                },
                fCategoryName: {
                    required: true,
                    minlength: 2
                },
                fCategoryDesc: {
                    required: true,
                    minlength: 2
                },
                fAssetTypeName: {
                    required: true,
                    minlength: 2
                },
                fAssetTypeDesc: {
                    required: true,
                    minlength: 2
                },
                fLocationName: {
                    required: true,
                    minlength: 2
                },
                fLocationDesc: {
                    required: true,
                    minlength: 2
                },
                fVendorName: {
                    required: true,
                    minlength: 2
                },
                fAddress1: {
                    required: true,
                    minlength: 2
                },
                fCity: {
                    required: true,
                    minlength: 2
                },
                fState: {
                    required: true,
                    minlength: 2
                },
                fPincode: {
                    required: true,
                    digits: true
                },
                fCountry: {
                    required: true,
                    minlength: 2
                },
                fPhone1: {
                    required: true,
                    digits: true
                },
                fContactPerson1: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                fAssetUnitName: {
                    required: "Please Enter the Unit Name"
                },
                fAssetUnitDesc: {
                    required: "Please Enter the Unit Description"
                },
                fBuildingName: {
                    required: "Please Enter the Building Name"
                },
                fBuildingDesc: {
                    required: "Please Enter the Building Description"
                },
                fDepartmentName: {
                    required: "Please Enter the Department Name"
                },
                fDepartmentDesc: {
                    required: "Please Enter the Department Description"
                },
                fCategoryName: {
                    required: "Please Enter the Category Name"
                },
                fCategoryDesc: {
                    required: "Please Enter the Category Description"
                },
                fAssetTypeName: {
                    required: "Please Enter the Asset Type Name"
                },
                fAssetTypeDesc: {
                    required: "Please Enter the Asset Type Description"
                },
                fLocationName: {
                    required: "Please Enter the Location Name"
                },
                fLocationDesc: {
                    required: "Please Enter the Location Description"
                },
                fVendorName: {
                    required: "Please Enter Vendor Name"
                },
                fAddress1: {
                    required: "Please Enter Adderess"
                },
                fCity: {
                    required: "Please Enter City"
                },
                fState: {
                    required: "Please Enter State"
                },
                fPincode: {
                    required: "Please Enter Pincode"
                },
                fCountry: {
                    required: "Please Enter Country"
                },
                fPhone1: {
                    required: "Please Enter Phone Numbers"
                },
                fContactPerson1: {
                    required: "Please Enter Contact Person"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "education") {
                    error.insertAfter("#form_2_education_chzn");
                } else if (element.attr("name") == "membership") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else if (element.attr("name") == "service") {
                    error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                success3.hide();
                error3.show();
                App.scrollTo(error3, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                success3.show();
                error3.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', form3).change(function() {
            form3.validate().element($(this));
        });
        var register = $('#register');
        var registererror = $('.alert-error', register);
        var registersuccess = $('.alert-success', register);
        register.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            ignore: "input[type='text']:hidden",
            rules: {
                fFirstName: {
                    required: true,
                    minlength: 2
                },
                fAddr1: {
                    required: true,
                    minlength: 2
                },
                fPhone: {
                    required: true,
                    minlength: 8
                },
                fLoginName: {
                    required: true,
                    minlength: 2
                },
                fPassword: {
                    required: true
                },
                fConfirmPassword: {
                    equalTo: "#register_password"
                },
            },
            messages: {
                fFirstName: {
                    required: "Please Enter the User First Name"
                },
                fAddr1: {
                    required: "Please Enter Address"
                },
                fPhone: {
                    required: "Please Enter Telephone / Mobile Number"
                },
                fLoginName: {
                    required: "Please Enter the User Login Name"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "education") {
                    error.insertAfter("#form_2_education_chzn");
                } else if (element.attr("name") == "membership") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else if (element.attr("name") == "service") {
                    error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                registersuccess.hide();
                registererror.show();
                App.scrollTo(registererror, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                registersuccess.hide();
                registererror.show();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', register).change(function() {
            register.validate().element($(this));
        });
        var register1 = $('#register1');
        var register1error = $('.alert-error', register1);
        var register1success = $('.alert-success', register1);
        register1.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fLoginName: {
                    required: true,
                    minlength: 2
                },
                fPassword: {
                    required: true
                },
                fConfirmPassword: {
                    equalTo: "#register_password"
                }
            },
            messages: {
                fLoginName: {
                    required: "Please Enter the User Login Name"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "education") {
                    error.insertAfter("#form_2_education_chzn");
                } else if (element.attr("name") == "membership") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else if (element.attr("name") == "service") {
                    error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                alert("hai");
                register1success.hide();
                register1error.show();
                App.scrollTo(register1error, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                register1success.hide();
                register1error.show();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', register1).change(function() {
            register1.validate().element($(this));
        });
        var form4 = $('#form_sample_4');
        var error4 = $('.alert-error', form4);
        var success4 = $('.alert-success', form4);
        form4.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: false,
            ignore: "",
            rules: {
                fAssetUnitName: {
                    required: true,
                    minlength: 2
                },
                fAssetUnitDesc: {
                    required: true,
                    minlength: 2
                },
                fBuildingName: {
                    required: true,
                    minlength: 2
                },
                fBuildingDesc: {
                    required: true,
                    minlength: 2
                },
                fDepartmentName: {
                    required: true,
                    minlength: 2
                },
                fDepartmentDesc: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                fAssetUnitName: {
                    required: "Please Enter the Unit Name"
                },
                fAssetUnitDesc: {
                    required: "Please Enter the Unit Description"
                },
                fBuildingName: {
                    required: "Please Enter the Building Name"
                },
                fBuildingDesc: {
                    required: "Please Enter the Building Description"
                },
                fDepartmentName: {
                    required: "Please Enter the Department Name"
                },
                fDepartmentDesc: {
                    required: "Please Enter the Department Description"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "education") {
                    error.insertAfter("#form_2_education_chzn");
                } else if (element.attr("name") == "membership") {
                    error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                } else if (element.attr("name") == "service") {
                    error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                } else {
                    error.insertAfter(element);
                }
            },
            invalidHandler: function(event, validator) {
                success4.hide();
                error4.show();
                App.scrollTo(error4, -200);
            },
            highlight: function(element) {
                $(element).closest('.help-inline').removeClass('ok');
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element) {
                $(element).closest('.control-group').removeClass('error');
            },
            success: function(label) {
                if (label.attr("for") == "service" || label.attr("for") == "membership") {
                    label.closest('.control-group').removeClass('error').addClass('success');
                    label.remove();
                } else {
                    label.addClass('valid').addClass('help-inline ok').closest('.control-group').removeClass('error').addClass('success');
                }
            },
            submitHandler: function(form) {
                success4.show();
                error4.hide();
                form.submit();
            }
        });
        $('.chosen, .chosen-with-diselect', form4).change(function() {
            form4.validate().element($(this));
        });
    }
    var handleTree = function() {
        $('#tree_1_collapse').click(function() {
            $('.tree-toggle', $('#tree_1 > li > ul')).addClass("closed");
            $('.branch', $('#tree_1 > li > ul')).removeClass("in");
        });
        $('#tree_1_expand').click(function() {
            $('.tree-toggle', $('#tree_1 > li > ul')).removeClass("closed");
            $('.branch', $('#tree_1 > li > ul')).addClass("in");
        });
        $('#tree_2_collapse').click(function() {
            $('.tree-toggle', $('#tree_2 > li > ul')).addClass("closed");
            $('.branch', $('#tree_2 > li > ul')).removeClass("in");
        });
        $('#tree_2_expand').click(function() {
            $('.tree-toggle', $('#tree_2 > li > ul')).each(function() {
                $(this).click();
            });
            $('.branch', $('#tree_2 > li > ul')).addClass("in");
        });
        $("#tree_1").on("nodeselect.tree.data-api", "[data-role=leaf]", function(e) {
            var output = "";
            output += "Node nodeselect event fired:\n";
            output += "Node Type: leaf\n";
            output += "Value: " + ((e.node.value) ? e.node.value : e.node.el.text()) + "\n";
            output += "Parentage: " + e.node.parentage.join("/");
            alert(output);
        });
        $("#tree_1").on("nodeselect.tree.data-api", "[role=branch]", function(e) {
            var output = "Node nodeselect event fired:\n"; + "Node Type: branch\n" + "Value: " + ((e.node.value) ? e.node.value : e.node.el.text()) + "\n" + "Parentage: " + e.node.parentage.join("/") + "\n"
            alert(output);
        })
        $("#tree_1").on("openbranch.tree", "[data-toggle=branch]", function(e) {
            var output = "Node openbranch event fired:\n" + "Node Type: branch\n" + "Value: " + ((e.node.value) ? e.node.value : e.node.el.text()) + "\n" + "Parentage: " + e.node.parentage.join("/") + "\n"
            alert(output);
        })
        $("#tree_1").on("closebranch.tree", "[data-toggle=branch]", function(e) {
            var output = "Node closebranch event fired:\n" + "Node Type: branch\n" + "Value: " + ((e.node.value) ? e.node.value : e.node.el.text()) + "\n" + "Parentage: " + e.node.parentage.join("/") + "\n"
            alert(output);
        })
    }
    return {
        init: function() {
            handleResponsive();
            handleUniform();
            if (App.isPage("index")) {
                handleDashboardCharts();
                handleJQVMAP();
                handleDashboardCalendar();
                handleChat();
            }
            if (App.isPage("grids")) {
                handlePortletSortable();
            }
            if (App.isPage("calendar")) {
                handleCalendar();
            }
            if (App.isPage("maps_vector")) {
                handleAllJQVMAP();
            }
            if (App.isPage("charts")) {
                handleCharts();
                handleChartGraphs();
            }
            if (App.isPage("sliders")) {
                handleSliders();
                handlKnobElements()
            }
            if (App.isPage("table_editable")) {
                handleEditableTables();
            }
            if (App.isPage("table_managed")) {
                handleTables();
            }
            if (App.isPage("ui_nestable")) {
                handleNestableList();
            }
            if (App.isPage("form_validation")) {
                handleFormValidation();
            }
            if (App.isPage("contracts")) {
                handleFormValidation();
            }
            if (App.isPage("ItemCategory")) {
                handleFormValidation();
                handleTables();
            }
            if (App.isPage("ui_tree")) {
                handleTree();
            }
            handleChoosenSelect();
            handleScrollers();
            handleTagsInput()
            handleDateTimePickers();
            handleClockfaceTimePickers();
            handleColorPicker();
            handlePortletTools();
            handlePulsate();
            handleGritterNotifications();
            handleTooltip();
            handlePopover();
            handleToggleButtons();
            handleWysihtml5();
            handleFancyBox();
            handleStyler();
            handleMainMenu();
            handleSidebarToggler()
            handleFixInputPlaceholderForIE();
            handleGoTop();
            handleAccordions();
            handleFormWizards();
        },
        initLogin: function() {
            handleLoginForm();
            handleUniform();
            handleFixInputPlaceholderForIE();
        },
        pulsate: function(el, options) {
            var opt = jQuery.extend(options, {
                color: '#d12610',
                reach: 15,
                speed: 300,
                pause: 0,
                glow: false,
                repeat: 1,
                onHover: false
            });
            jQuery(el).pulsate(opt);
        },
        scrollTo: function(el, offeset) {
            pos = el ? el.offset().top : 0;
            jQuery('html,body').animate({
                scrollTop: pos + (offeset ? offeset : 0)
            }, 'slow');
        },
        blockUI: function(el, loaderOnTop) {
            lastBlockedUI = el;
            jQuery(el).block({
                message: '<img src="./assets/img/loading.gif" align="absmiddle">',
                css: {
                    border: 'none',
                    padding: '2px',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.05,
                    cursor: 'wait'
                }
            });
        },
        unblockUI: function(el) {
            jQuery(el).unblock({
                onUnblock: function() {
                    jQuery(el).removeAttr("style");
                }
            });
        },
        initFancybox: function() {
            handleFancyBox();
        },
        initUniform: function(el) {
            initUniform(el);
        },
        initChosenSelect: function(el) {
            initChosenSelect(el);
        },
        getActualVal: function(el) {
            var el = jQuery(el);
            if (el.val() === el.attr("placeholder")) {
                return "";
            }
            return el.val();
        },
        setPage: function(name) {
            currentPage = name;
        },
        isPage: function(name) {
            return currentPage == name ? true : false;
        },
        isTouchDevice: function() {
            try {
                document.createEvent("TouchEvent");
                return true;
            } catch (e) {
                return false;
            }
        }
    };
}();
$(function() {
    setTimeout("ShowTime()", 1000);
});

function ShowTime() {
    var dt = new Date();
    $("#lblTime").html(dt.toLocaleTimeString());
    setTimeout("ShowTime()", 1000);
}
