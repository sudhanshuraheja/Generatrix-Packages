<?php

	/*
		You can do the following in the controller

		1. TO DISPLAY ERRORS :
				display_error("Calls to the function <strong>display_error($message)</strong> are displayed like this");
				display_warning("Calls to the function <strong>display_warning($message)</strong> are displayed like this");
				display_system("Calls to the function <strong>display_system($message)</strong> are displayed like this");
				display("Calls to the function <strong>display($message)</strong> are displayed like this");

		2. TO HANDLE DATABASES :
				If you have the following table
				CREATE TABLE IF NOT EXISTS `students` (
					`id` int(11) NOT NULL auto_increment,
					`name` varchar(64) NOT NULL,
					`phone` varchar(64) NOT NULL,
					`status` varchar(128) NOT NULL,
				PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

				Then run php index.php generatrix preparedb

				This would create a class students and you can run
				$students = new students($this->getDb());
				$students_data = $students->select("*", "WHERE id=5");
				$students_data = $students->delete("WHERE id=5");
				$students_data = $students->update(array("name" => "sudhanshu"), "WHERE id=5");
				$students_data = $students->insert(array("name" => "sudhanshu", "phone" => "1234567890", "status" => "working on generatrix"));

		3. TO PASS VALUES TO THE VIEW :
				$this->set("sample", "This is sample content which was set in the controller");
				$this->set("students_data", $students_data);
	*/

	class packagesController extends Controller {

		public function sendData($package_data) {
			$output = array();
			foreach($package_data as $package) {
				$user = checkArray($package, 'user') ? $package['user'] : false;
				$repo = checkArray($package, 'repo') ? $package['repo'] : false;
				$description = checkArray($package, 'description') ? $package['description'] : false;

				if($user && $repo && $description) {
					$output[$user . ':' . $repo] = array(
						'user' => $user,
						'repo' => $repo,
						'description' => $description
					);
				}
			}

			return json_encode($output);
		}

		public function base() {
			$this->isHtml(false);
			$packages = new packages($this->getDb());
			$package_data = $packages->select('user, repo, description, created', 'WHERE is_approved="1"');
			echo $this->sendData($package_data);
		}

		public function search() {
			$term = $this->getP3();

			if(!$term)
				echo json_encode(array());

			$this->isHtml(false);
			$packages = new packages($this->getDb());
			$package_data = $packages->select(
				'user, repo, description, created',
				'WHERE is_approved="1" AND user LIKE "%' . $term . '%" OR repo LIKE "%' . $term . '%" OR description LIKE "%' . $term . '%"'
			);
			echo $this->sendData($package_data);
		}

	}

?>
