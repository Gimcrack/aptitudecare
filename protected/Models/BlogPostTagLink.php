<?php

	class BlogPostTagLink extends AppModel {

		protected $table = 'blog_post_tag_link';
		
		public function deleteExisting($blog_id) {
			$blogPost = $this->loadTable('BlogPost');

			$sql = "DELETE {$this->tableName()} FROM {$this->tableName()} INNER JOIN {$blogPost->tableName()} ON {$blogPost->tableName()}.id = {$this->tableName()}.blog_post_id WHERE {$blogPost->tableName()}.public_id = :id";
			$params[":id"] = $blog_id;

			if ($this->deleteQuery($sql, $params)) {
				return true;
			}

			return false;
		}

	}