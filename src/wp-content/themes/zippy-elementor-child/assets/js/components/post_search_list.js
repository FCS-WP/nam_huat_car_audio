document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("post-search-component");
  if (!container) return;

  const allPosts = JSON.parse(container.dataset.posts);
  console.log(allPosts);

  const listEl = document.getElementById("post-list");
  const searchInput = document.getElementById("post-search-input");

  const initialPosts = allPosts.slice(0, 4);

  function renderPosts(posts) {
    listEl.innerHTML = posts
      .map(
        (p) => `
            <a href="${p.link}" class="post-item">
                <img src="${p.thumbnail}" />
                <div>
                    <div class="post-title">${p.title}</div>
                    <div class="post-date">${p.date}</div>
                </div>
            </a>`
      )
      .join("");
  }

  renderPosts(initialPosts);

  searchInput.addEventListener("input", function () {
    const keyword = this.value.toLowerCase().trim();

    if (keyword === "") {
      renderPosts(initialPosts);
      return;
    }

    const filtered = allPosts.filter((p) =>
      p.title.toLowerCase().includes(keyword)
    );

    renderPosts(filtered);
  });
});
