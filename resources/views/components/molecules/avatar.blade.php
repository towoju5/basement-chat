<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" {{ $attributes }} x-data="randomColor">
    <mask id="viewboxMask">
        <rect width="100" height="100" rx="0" ry="0" x="0" y="0" fill="#fff"/>
    </mask>
    <g mask="url(#viewboxMask)">
        <rect x-bind:fill="color" width="100" height="100" x="0" y="0"/>
        <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="50" font-weight="400" fill="#ffffff"
              text-anchor="middle" dy="17.800" x-text="contact.avatarText">

        </text>
    </g>
</svg>

<script>
    function randomColor() {
        return {
            color: '#000000',
            generateNewColor() {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                this.color = `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            },
            init() {
                this.generateNewColor();
            }
        }
    }
</script>
