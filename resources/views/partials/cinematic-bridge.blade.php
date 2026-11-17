<script>
    (() => {
        const VIDEO_KEY = 'cinematicVideoTime';
        const video = document.querySelector('[data-cinematic-video]');

        const saveTime = () => {
            if (!video) return;
            sessionStorage.setItem(VIDEO_KEY, String(video.currentTime || 0));
        };

        const restoreTime = () => {
            if (!video) return;
            const saved = parseFloat(sessionStorage.getItem(VIDEO_KEY) || '');
            if (Number.isNaN(saved)) return;

            const apply = () => {
                try {
                    const duration = video.duration || 0;
                    video.currentTime = duration > 0 ? saved % duration : saved;
                } catch (e) {}
            };

            if (video.readyState >= 1) apply();
            else video.addEventListener('loadedmetadata', apply, { once: true });
        };

        const tryPlay = () => {
            if (!video) return;
            const playPromise = video.play();
            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(() => {});
            }
        };

        restoreTime();
        tryPlay();

        if (video) {
            setInterval(saveTime, 250);
            video.addEventListener('timeupdate', () => {
                if (Math.floor(video.currentTime * 4) % 4 === 0) saveTime();
            });
        }

        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) tryPlay();
        });

        document.querySelectorAll('a.js-cinematic-bridge').forEach((link) => {
            link.addEventListener('click', (event) => {
                saveTime();

                if (!document.startViewTransition) {
                    event.preventDefault();
                    document.documentElement.classList.add('is-bridging');
                    window.setTimeout(() => {
                        window.location.href = link.href;
                    }, 340);
                }
            });
        });

        document.documentElement.classList.add('cinematic-ready');
    })();
</script>
