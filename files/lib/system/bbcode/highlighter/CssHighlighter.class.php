<?php
namespace wcf\system\bbcode\highlighter;

/**
 * Highlights syntax of cascading style sheets.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class CssHighlighter extends Highlighter {
	// highlighter style
	protected $style = array(
		'quotes' => 'color:red',
		'comments' => 'color:#236E26',
		'colors' => 'color:#751116',
		'numbers' => 'color:#1906FD',
		'keywords1' => 'color:#87154F',
		'keywords2' => 'color:#994509',
		'keywords3' => '',
		'keywords4' => ''
	);

	/**
	 * Highlights numbers.
	 */
	protected function highlightNumbers($string) {
		$string = preg_replace('!(?<='.$this->separatorsRegEx.')(-?\d+(?:px|pt|em|%|ex|in|cm|mm|pc)?)(?='.$this->separatorsRegEx.')!i', '<span style="'.$this->style['numbers'].'">\\0</span>', $string);
		
		// highlight colors (hexadecimal numbers)
		$string = preg_replace('!(?<='.$this->separatorsRegEx.')(#([0-9a-f]{3}|[0-9a-f]{6}))(?='.$this->separatorsRegEx.')!i', '<span style="'.$this->style['colors'].'">\\0</span>', $string);
		
		return $string;
	}
	
	// highlighter syntax
	protected $singleLineComment = array();
	protected $separators = array('(', ')', '{', '}', ';', '[', ']', ':');
	protected $keywords1 = array(
		'azimuth',
		'background',
		'background-attachment',
		'background-clip',
		'background-color',
		'background-image',
		'background-origin',
		'background-position',
		'background-repeat',
		'background-size',
		'border',
		'border-bottom',
		'border-bottom-color',
		'border-bottom-radius',
		'border-bottom-left-radius',
		'border-bottom-right-radius',
		'border-bottom-style',
		'border-bottom-width',
		'border-collapse',
		'border-color',
		'border-left',
		'border-left-color',
		'border-left-radius',
		'border-left-style',
		'border-left-width',
		'border-radius',
		'border-right',
		'border-right-color',
		'border-right-radius',
		'border-right-style',
		'border-right-width',
		'border-spacing',
		'border-style',
		'border-top',
		'border-top-color',
		'border-top-radius',
		'border-top-left-radius',
		'border-top-right-radius',
		'border-top-style',
		'border-top-width',
		'border-width',
		'bottom',
		'box-shadow',
		'caption-side',
		'clear',
		'clip',
		'color',
		'content',
		'counter-increment',
		'counter-reset',
		'cue',
		'cue-after',
		'cue-before',
		'cursor',
		'direction',
		'display',
		'elevation',
		'empty-cells',
		'float',
		'font',
		'font-family',
		'font-size',
		'font-style',
		'font-variant',
		'font-weight',
		'height',
		'left',
		'letter-spacing',
		'line-height',
		'list-style',
		'list-style-image',
		'list-style-position',
		'list-style-type',
		'margin',
		'margin-bottom',
		'margin-left',
		'margin-right',
		'margin-top',
		'max-height',
		'max-width',
		'min-height',
		'min-width',
		'opacity',
		'orphans',
		'outline',
		'outline-color',
		'outline-style',
		'outline-width',
		'overflow',
		'overflow-x',
		'overflow-y',
		'padding',
		'padding-bottom',
		'padding-left',
		'padding-right',
		'padding-top',
		'page-break-after',
		'page-break-before',
		'page-break-inside',
		'pause',
		'pause-after',
		'pause-before',
		'pitch',
		'pitch-range',
		'play-during',
		'position',
		'quotes',
		'richness',
		'right',
		'scrollbar-3dlight-color',
		'scrollbar-arrow-color',
		'scrollbar-base-color',
		'scrollbar-darkshadow-color',
		'scrollbar-face-color',
		'scrollbar-highlight-color',
		'scrollbar-shadow-color',
		'scrollbar-track-color',
		'speak',
		'speak-header',
		'speak-numeral',
		'speak-punctuation',
		'speech-rate',
		'stress',
		'table-layout',
		'text-align',
		'text-decoration',
		'text-indent',
		'text-overflow',
		'text-shadow',
		'text-transform',
		'top',
		'unicode-bidi',
		'vertical-align',
		'visibility',
		'voice-family',
		'volume',
		'white-space',
		'widows',
		'width',
		'word-spacing',
		'word-wrap',
		'z-index',
		'!important',
		'@import',
		'@media'
	);
	
	protected $keywords2 = array(
		'left-side',
		'far-left',
		'left',
		'center-left',
		'center-right',
		'center',
		'far-right',
		'right-side',
		'right',
		'behind',
		'leftwards',
		'rightwards',
		'inherit',
		'scroll',
		'fixed',
		'transparent',
		'none',
		'repeat-x',
		'repeat-y',
		'repeat',
		'no-repeat',
		'collapse',
		'separate',
		'auto',
		'top',
		'bottom',
		'both',
		'open-quote',
		'close-quote',
		'no-open-quote',
		'no-close-quote',
		'crosshair',
		'default',
		'pointer',
		'move',
		'e-resize',
		'ne-resize',
		'nw-resize',
		'n-resize',
		'se-resize',
		'sw-resize',
		's-resize',
		'text',
		'wait',
		'help',
		'ltr',
		'rtl',
		'inline',
		'block',
		'list-item',
		'run-in',
		'compact',
		'marker',
		'table',
		'inline-table',
		'table-row-group',
		'table-header-group',
		'table-footer-group',
		'table-row',
		'table-column-group',
		'table-column',
		'table-cell',
		'table-caption',
		'below',
		'level',
		'above',
		'higher',
		'lower',
		'show',
		'hide',
		'caption',
		'icon',
		'menu',
		'message-box',
		'small-caption',
		'status-bar',
		'normal',
		'wider',
		'narrower',
		'ultra-condensed',
		'extra-condensed',
		'condensed',
		'semi-condensed',
		'semi-expanded',
		'expanded',
		'extra-expanded',
		'ultra-expanded',
		'italic',
		'oblique',
		'small-caps',
		'bold',
		'bolder',
		'lighter',
		'inside',
		'outside',
		'disc',
		'circle',
		'square',
		'decimal',
		'decimal-leading-zero',
		'lower-roman',
		'upper-roman',
		'lower-greek',
		'lower-alpha',
		'lower-latin',
		'upper-alpha',
		'upper-latin',
		'hebrew',
		'armenian',
		'georgian',
		'cjk-ideographic',
		'hiragana',
		'katakana',
		'hiragana-iroha',
		'katakana-iroha',
		'crop',
		'cross',
		'invert',
		'visible',
		'hidden',
		'always',
		'avoid',
		'x-low',
		'low',
		'medium',
		'high',
		'x-high',
		'mix?',
		'repeat?',
		'static',
		'relative',
		'absolute',
		'portrait',
		'landscape',
		'spell-out',
		'once',
		'digits',
		'continuous',
		'code',
		'x-slow',
		'slow',
		'fast',
		'x-fast',
		'faster',
		'slower',
		'justify',
		'underline',
		'overline',
		'line-through',
		'blink',
		'capitalize',
		'uppercase',
		'lowercase',
		'embed',
		'bidi-override',
		'baseline',
		'sub',
		'super',
		'text-top',
		'middle',
		'text-bottom',
		'silent',
		'x-soft',
		'soft',
		'loud',
		'x-loud',
		'pre',
		'nowrap',
		'serif',
		'sans-serif',
		'cursive',
		'fantasy',
		'monospace',
		'empty',
		'string',
		'strict',
		'loose',
		'char',
		'true',
		'false',
		'dotted',
		'dashed',
		'solid',
		'double',
		'groove',
		'ridge',
		'inset',
		'outset',
		'larger',
		'smaller',
		'xx-small',
		'x-small',
		'small',
		'large',
		'x-large',
		'xx-large',
		'all',
		'newspaper',
		'distribute',
		'distribute-all-lines',
		'distribute-center-last',
		'inter-word',
		'inter-ideograph',
		'inter-cluster',
		'kashida',
		'ideograph-alpha',
		'ideograph-numeric',
		'ideograph-parenthesis',
		'ideograph-space',
		'keep-all',
		'break-all',
		'break-word',
		'lr-tb',
		'tb-rl',
		'thin',
		'thick',
		'inline-block',
		'w-resize',
		'hand',
		'distribute-letter',
		'distribute-space',
		'whitespace',
		'male',
		'female',
		'child',
		'print',
		'screen',
		'tty',
		'aural',
		'all',
		'braille',
		'embossed',
		'handheld',
		'projection',
		'tv',
		'hsl',
		'hsla',
		'rgb',
		'rgba'
	);
	
	protected $keywords3 = array(
		'active',
		'after',
		'before',
		'checked',
		'disabled',
		'empty',
		'enabled',
		'first-child',
		'first-letter',
		'first-line',
		'first-of-type',
		'focus',
		'lang',
		'last-child',
		'last-of-type',
		'link',
		'hover',
		'not',
		'nth-child',
		'nth-last-child',
		'nth-of-type',
		'nth-last-of-type'
		'only-child',
		'only-of-type',
		'root',
		'target',
		'visited'
	);

	protected $keywords4 = array(
		'body',
		'html',
		'title',
		'abbr',
		'acronym',
		'address',
		'blockquote',
		'br',
		'cite',
		'code',
		'dfn',
		'div',
		'em',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'kbd',
		'p',
		'pre',
		'q',
		'samp',
		'strong',
		'a',
		'dl',
		'dt',
		'dd',
		'ol',
		'ul',
		'li',
		'b',
		'big',
		'hr',
		'i',
		'small',
		'sub',
		'sup',
		'tt',
		'object',
		'del',
		'ins',
		'bdo',
		'button',
		'fieldset',
		'form',
		'input',
		'label',
		'legend',
		'select',
		'optgroup',
		'option',
		'textarea',
		'caption',
		'col',
		'colgroup',
		'table',
		'tbody',
		'td',
		'tfoot',
		'th',
		'thead',
		'tr',
		'img',
		'noscript',
		'ruby',
		'rbc',
		'rtc',
		'rb',
		'rt',
		'rp'
	);
}
